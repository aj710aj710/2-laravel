<?php

namespace App\Http\Services;

use App\Models\Beneficiary;
use App\Models\User;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class BeneficiaryService
{
    use ResponseTrait;

    public function getAll()
    {
        return User::where('role', USER_ROLE_AFFILIATE)->where('created_by', auth()->id())->get();
    }

    public function getUserBeneficiary()
    {
        return Beneficiary::where('user_id', auth()->id())->get();
    }

    public function getInfoById($id)
    {
        return Beneficiary::where('user_id', auth()->id())->where('id', $id)->first();
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $data = [
                "beneficiary_name" => $request->beneficiary_name,
                "type" => $request->type,
                "status" => $request->status,
                "user_id" => auth()->id(),
            ];

            if ($request->type == BENEFICIARY_BANK) {
                $data["bank_name"] = $request->bank_name;
                $data["account_name"] = $request->account_name;
                $data["bank_account_number"] = $request->bank_account_number;
                $data["bank_routing_number"] = $request->bank_routing_number;
            } elseif ($request->type == BENEFICIARY_PAYPAL) {
                $data["paypal_email"] = $request->paypal_email;
            } elseif ($request->type == BENEFICIARY_CARD) {
                $data["card_number"] = $request->card_number;
                $data["card_holder_name"] = $request->card_holder_name;
                $data["expire_month"] = $request->expire_month;
                $data["expire_year"] = $request->expire_year;
            }

            Beneficiary::create($data);
            DB::commit();
            return $this->success([], __('Saved Successfully'));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], SOMETHING_WENT_WRONG);
        }
    }

    public function update($id, $request)
    {
        try {
            DB::beginTransaction();
            $data = [
                "beneficiary_name" => $request->beneficiary_name,
                "type" => $request->type,
                "status" => $request->status,
            ];

            if ($request->type == BENEFICIARY_BANK) {
                $data["bank_name"] = $request->bank_name;
                $data["account_name"] = $request->account_name;
                $data["bank_account_number"] = $request->bank_account_number;
                $data["bank_routing_number"] = $request->bank_routing_number;
            } elseif ($request->type == BENEFICIARY_PAYPAL) {
                $data["paypal_email"] = $request->paypal_email;
            } elseif ($request->type == BENEFICIARY_CARD) {
                $data["card_number"] = $request->card_number;
                $data["card_holder_name"] = $request->card_holder_name;
                $data["expire_month"] = $request->expire_month;
                $data["expire_year"] = $request->expire_year;
            }

            Beneficiary::where('id', $id)->update($data);
            DB::commit();
            return $this->success([], __('Update Successfully'));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], SOMETHING_WENT_WRONG);
        }
    }

    public function deleteById($id)
    {
        try {
            DB::beginTransaction();
            $beneficiary = Beneficiary::where('id', $id)->first();

            if (count($beneficiary->withdrawals) != 0) {
                return $this->error([], __('This beneficiary is already used'));
            }

            $beneficiary->delete();
            DB::commit();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }
}
