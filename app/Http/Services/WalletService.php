<?php

namespace App\Http\Services;

use App\Models\Beneficiary;
use App\Models\Withdraw;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WalletService
{
    use ResponseTrait;

    public function getAllData($user_id = null)
    {
        $data = Withdraw::query()
            ->when($user_id, function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            });

        return datatables($data)
            ->addIndexColumn()
            ->addColumn('date', function ($data) {
                return $data->created_at?->format('Y-md');
            })
            ->addColumn('payment_details', function ($data) {
                return getBeneficiaryDetails($data->beneficiary);
            })
            ->addColumn('amount', function ($data) {
                return showPrice($data->amount);
            })
            ->addColumn('status', function ($data) {
                if ($data->status == STATUS_ACTIVE) {
                    return "<p class='zBadge zBadge-success'>" . __('Approved') . "</p>";
                } elseif ($data->status == STATUS_CANCELED) {
                    return "<p class='zBadge zBadge-inactive'>" . __('Rejected') . "</p>";
                } else {
                    return "<p class='zBadge zBadge-fuilure'>" . __('Pending') . "</p>";
                }
            })
            ->rawColumns(['type', 'payment_details', 'status', 'amount'])
            ->make(true);
    }

    public function getWithdrawRequestByStatus($request)
    {
        $status = 0;
        if ($request->status == 'Paid') {
            $status = PAYMENT_STATUS_PAID;
        } else if ($request->status == 'Pending') {
            $status = PAYMENT_STATUS_PENDING;
        } else if ($request->status == 'Cancelled') {
            $status = PAYMENT_STATUS_CANCELLED;
        }

        $withdrawals = Withdraw::join('users', 'users.id', '=', 'withdraws.user_id')
            ->with('beneficiary')
            ->select([
                'withdraws.*',
                'users.name as userName',
            ]);

        if ($request->status == 'All') {
            $data = $withdrawals;
        } else {
            $data = $withdrawals->where('withdraws.status', $status);
        }

        return datatables($data)
            ->addIndexColumn()
            ->addColumn('date', function ($data) {
                return $data->created_at?->format('Y-md');
            })
            ->addColumn('payment_details', function ($data) {
                return getBeneficiaryDetails($data->beneficiary);
            })
            ->addColumn('amount', function ($data) {
                return showPrice($data->amount);
            })
            ->addColumn('status', function ($data) {
                if ($data->status == STATUS_ACTIVE) {
                    return "<p class='zBadge zBadge-success'>" . __('Approved') . "</p>";
                } elseif ($data->status == STATUS_CANCELED) {
                    return "<p class='zBadge zBadge-inactive'>" . __('Rejected') . "</p>";
                } else {
                    return "<p class='zBadge zBadge-fuilure'>" . __('Pending') . "</p>";
                }
            })
            ->addColumn('action', function ($data) {
                $html = '<div class="d-flex justify-content-end align-items-center g-10">';
                $html .= "<button type='button' class='border-0 p-0 bg-transparent flex-shrink-0 me-2' onclick='getEditModal(\"" . route("user.affiliate.withdraw.request.status.edit", $data->id) . "\"" . ", \"#edit-modal\")' title='Edit'><img src='" . asset('user/images/icon/edit.svg') . "' alt=''></button>";

                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['type', 'payment_details', 'status', 'amount', 'action'])
            ->make(true);
    }

    public function getWithdraw($id)
    {
        return Withdraw::find($id);
        try {
            $data = Withdraw::find($id);
            if (is_null($data)) {
                return $this->error([], getMessage(SOMETHING_WENT_WRONG));
            }
            return $data;
        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function withdrawRequest($request)
    {
        if ($request->amount > auth()->user()->affiliate_commission_amount) {
            return $this->error([], __('Insufficient balance'));
        } else {
            DB::beginTransaction();
            try {
                $beneficiary = Beneficiary::where('id', $request->beneficiary_id)->firstOrFail();
                $withdraw = new Withdraw();
                $withdraw->user_id = auth()->id();
                $withdraw->tnxId = Str::uuid()->getHex();
                $withdraw->amount = $request->amount;
                $withdraw->beneficiary_id = $request->beneficiary_id;
                $withdraw->save();
                auth()->user()->decrement('affiliate_commission_amount', (float)$request->amount);
                createTransaction(auth()->id(), $request->amount, TRANSACTION_WITHDRAWAL,  $withdraw->id, 'Withdrawal via beneficiary ' . $beneficiary->beneficiary_name);

                //notification call start
                setCommonNotification('New Withdraw Request Received', 'Withdrawal via beneficiary ' . $beneficiary->beneficiary_name, '', auth()->id());

                DB::commit();
                return $this->success([], __('Successfully Requested'));
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->error([], __('Something Went Wrong'));
            }
        }
    }

    public function withdrawRequestStatusChange($request)
    {
        try {
            DB::beginTransaction();
            $withdraw = Withdraw::where('id', $request->id)->first();
            if ($request->status == STATUS_CANCELED) {
                $withdraw->user()->increment('affiliate_commission_amount', (float)$withdraw->amount);
                createTransaction($withdraw->user_id, $withdraw->amount, TRANSACTION_WITHDRAWAL_DISBURSED,  $withdraw->id, 'Withdrawal disbursed ' . $withdraw->beneficiary->beneficiary_name);

                //notification call start
                setCommonNotification('Withdrawal disbursed', 'Withdrawal disbursed ' .  $withdraw->beneficiary->beneficiary_name, '', $withdraw->user_id);
            } else {
                setCommonNotification('Withdrawal request approved', 'Withdrawal request approved ' .  $withdraw->beneficiary->beneficiary_name, '', $withdraw->user_id);
            }
            $withdraw->status = $request->status;
            $withdraw->save();
            DB::commit();
            return $this->success([], __('Successfully Changed'));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error([], __('Something Went Wrong'));
        }
    }
}
