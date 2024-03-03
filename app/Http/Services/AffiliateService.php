<?php

namespace App\Http\Services;

use App\Models\AffiliateConfig;
use App\Models\AffiliateHistory;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\User;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class AffiliateService
{
    use ResponseTrait;

    public function getAll()
    {
        return User::where('role', USER_ROLE_AFFILIATE)->where('created_by', auth()->id())->get();
    }

    public function getAllActive()
    {
        return User::where('role', USER_ROLE_AFFILIATE)->where('status', STATUS_ACTIVE)->where('created_by', auth()->id())->get();
    }

    public function getAllData()
    {
        $data = $this->getAll();

        return datatables($data)
            ->addIndexColumn()
            ->editColumn('name', function ($data) {
                return $data->name;
            })
            ->addColumn('status', function ($data) {
                if ($data->status == STATUS_ACTIVE) {
                    return "<p class='zBadge zBadge-success'>" . __('Approved') . "</p>";
                } elseif ($data->status == STATUS_DEACTIVATE) {
                    return "<p class='zBadge zBadge-inactive'>" . __('Deactivate') . "</p>";
                } else {
                    return "<p class='zBadge zBadge-fuilure'>" . __('Pending') . "</p>";
                }
            })
            ->editColumn('action', function ($data) {
                return "<div class='d-flex justify-content-end align-items-center g-10'>
                            <button class='border-0 p-0 bg-transparent flex-shrink-0 statusConfig' data-id='" . $data->id . "'>
                                <img src='" . asset('user') . "/images/icon/edit.svg' alt=''>
                            </button>
                        </div>";
            })
            ->rawColumns(['name', 'status', 'action'])
            ->make(true);
    }

    public function getAllConfig()
    {
        $affiliateIds = ['all', (string) auth()->id()];
        $affiliateConfigs = AffiliateConfig::query()
            ->where(function ($q) use ($affiliateIds) {
                foreach ($affiliateIds as $id) {
                    $q->orWhereJsonContains('affiliates', $id);
                }
            })
            ->where('user_id', auth()->user()->created_by)
            ->get();

        $productIds = [];
        $planIds = [];
        foreach ($affiliateConfigs as $affiliateConfig) {
            $productIds = array_unique(array_merge($productIds, array_values(json_decode($affiliateConfig->products))));
            $planIds = array_unique(array_merge($planIds, array_values(json_decode($affiliateConfig->plans))));
        }

        $data = Plan::query()
            ->where(function ($q) use ($productIds) {
                if (!in_array('all', $productIds)) {
                    $q->whereIn('product_id', array_map('intval', $productIds));
                }
            })
            ->where(function ($q) use ($planIds) {
                if (!in_array('all', $planIds)) {
                    $q->whereIn('id', array_map('intval', $planIds));
                }
            })
            ->where('status', STATUS_ACTIVE)
            ->get();
        return $data;
    }
    public function getConfigListData()
    {
        $data = AffiliateConfig::query()
            ->where('user_id', auth()->id())
            ->orderByDesc('id');

        return datatables($data)
            ->addIndexColumn()
            ->editColumn('products', function ($data) {
                if (in_array('all', json_decode($data->products))) {
                    return __('All');
                } else {
                    return __('Selected Products');
                };
            })
            ->editColumn('plans', function ($data) {
                if (in_array('all', json_decode($data->plans))) {
                    return __('All');
                } else {
                    return __('Selected plans');
                };
            })
            ->editColumn('affiliates', function ($data) {
                if (in_array('all', json_decode($data->affiliates))) {
                    return __('All');
                } else {
                    return __('Selected affiliates');
                };
            })
            ->editColumn('title', function ($data) {
                return $data->title;
            })
            ->editColumn('action', function ($data) {
                return "<div class='d-flex justify-content-end align-items-center g-10'>
                            <button class='border-0 p-0 bg-transparent flex-shrink-0 editConfig' data-id='" . $data->id . "'><img src='" . asset('user') . "/images/icon/edit.svg' alt=''></button>
                            <button class='border-0 p-0 bg-transparent flex-shrink-0' onclick='deleteItem(\"" . route("user.affiliate.config.delete", encrypt($data->id)) . "\", \"allAffiliateConfigDataTable\")'><img src='" . asset('user') . "/images/icon/delete.svg' alt=''></button>
                        </div>";
            })
            ->rawColumns(['title', 'action'])
            ->make(true);
    }

    public function getInfo($id)
    {
        return User::where('role', USER_ROLE_AFFILIATE)->where('created_by', auth()->id())->findOrFail($id);
    }

    public function statusChange($request)
    {
        try {
            if (!in_array($request->status, [STATUS_ACTIVE, STATUS_PENDING, STATUS_DEACTIVATE])) {
                throw new Exception(__(SOMETHING_WENT_WRONG));
            }
            $affiliate = User::where('role', USER_ROLE_AFFILIATE)
                ->where('created_by', auth()->id())
                ->findOrFail($request->id);
            $affiliate->status = $request->status;
            $affiliate->save();
            $message =  __(STATUS_UPDATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function configInfo($id)
    {
        return AffiliateConfig::findOrFail($id);
    }

    public function configStore($request)
    {
        DB::beginTransaction();
        try {
            if (in_array('all', $request->product_ids)) {
                $products = ['all'];
            } else {
                $products = $request->product_ids;
            }

            if (in_array('all', $request->plan_ids)) {
                $plans = ['all'];
            } else {
                $plans = $request->plan_ids;
            }

            if (in_array('all', $request->affiliate_ids)) {
                $affiliates = ['all'];
            } else {
                $affiliates = $request->affiliate_ids;
            }

            $affiliateConfigExist = AffiliateConfig::query()
                ->where(function ($q) use ($products) {
                    foreach ($products as $product_id) {
                        $q->orWhereJsonContains('products', $product_id);
                    }
                })
                ->where('user_id', auth()->id())
                ->whereNot('id', $request->id)
                ->exists();

            if ($affiliateConfigExist) {
                throw new Exception(__('Product Already Config'));
            }

            // data store
            $id = $request->get('id', 0);
            $affiliateConfig = AffiliateConfig::where('user_id', auth()->id())->find($id);
            if (is_null($affiliateConfig)) {
                $affiliateConfig = new AffiliateConfig();
            }
            $affiliateConfig->title = $request->title;
            $affiliateConfig->user_id = auth()->id();
            $affiliateConfig->products = json_encode($products);
            $affiliateConfig->plans = json_encode($plans);
            $affiliateConfig->affiliates = json_encode($affiliates);
            $affiliateConfig->commission_type = $request->commission_type;
            $affiliateConfig->commission_amount = $request->commission_amount;
            $affiliateConfig->recurring_commission_type = $request->recurring_commission_type;
            $affiliateConfig->recurring_commission_amount = $request->recurring_commission_amount;
            $affiliateConfig->save();

            DB::commit();
            $message = $request->id ? __(UPDATED_SUCCESSFULLY) : getMessage(__(CREATED_SUCCESSFULLY));
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function configDeleteById($id)
    {
        try {
            $config = AffiliateConfig::where('user_id', auth()->id())->findOrFail(decrypt($id));
            $config->delete();
            return $this->success([], __(DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function getAllAffiliateHistory($user_id = null)
    {
        $data = AffiliateHistory::query()
            ->leftJoin('products', 'affiliate_histories.product_id', '=', 'products.id')
            ->leftJoin('plans', 'affiliate_histories.plan_id', '=', 'plans.id')
            ->when($user_id, function ($q) use ($user_id) {
                $q->where('affiliate_histories.user_id', $user_id);
            })
            ->get();
        return $data;
    }

    public function affiliateHistoryMonthlyChartData($user_id = null)
    {
        $affiliateHistories = AffiliateHistory::query()
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%b') month"),
                DB::raw('sum(amount) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->when($user_id, function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })
            ->groupBy('month')
            ->get()
            ->toArray();

        $monthList = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthName = Carbon::create(date('Y'), $month, 1)->format('M');
            $monthList[$month] = $monthName;
        }

        foreach ($monthList as $month) {
            $monthlyData[$month] = 0;
        }

        foreach ($affiliateHistories as $history) {
            $monthlyData[$history['month']] = $history['total'];
        }
        $data['months'] = array_keys($monthlyData);
        $data['monthlyValue'] = array_values($monthlyData);
        return $data;
    }

    public function affiliateHistoryData()
    {
        $data = AffiliateHistory::query()
            ->leftJoin('products', 'affiliate_histories.product_id', '=', 'products.id')
            ->leftJoin('plans', 'affiliate_histories.plan_id', '=', 'plans.id')
            ->where('affiliate_histories.user_id', auth()->id())
            ->select('affiliate_histories.*', 'products.name as product_name', 'plans.name as plan_name', 'plans.price as plan_price');
            
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('product', function ($data) {
                return $data->product_name;
            })
            ->addColumn('plan', function ($data) {
                return $data->plan_name;
            })
            ->addColumn('date', function ($data) {
                return $data->created_at?->format('Y-m-d');
            })
            ->addColumn('plan_price', function ($data) {
                return showPrice($data->plan_price);
            })
            ->addColumn('amount', function ($data) {
                return showPrice($data->amount);
            })
            ->rawColumns(['product', 'plan', 'date', 'amount'])
            ->make(true);
    }

    public function affiliateTransactionData($user_id = null)
    {
        $data = Transaction::query()
            ->when($user_id, function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            });

        return datatables($data)
            ->addIndexColumn()
            ->addColumn('date', function ($data) {
                return $data->created_at?->format('Y-md');
            })
            ->addColumn('type', function ($data) {
                return transactionType($data->type);
            })
            ->addColumn('amount', function ($data) {
                return showPrice($data->amount);
            })
            ->rawColumns(['type', 'date', 'amount'])
            ->make(true);
    }

    public function affiliateHistoryDataForUser()
    {
        $data = AffiliateHistory::query()
            ->leftJoin('products', 'affiliate_histories.product_id', '=', 'products.id')
            ->leftJoin('plans', 'affiliate_histories.plan_id', '=', 'plans.id')
            ->leftJoin('users', 'affiliate_histories.user_id', '=', 'users.id')
            ->where('users.created_by', auth()->id())
            ->select('affiliate_histories.*', 'products.name as product_name', 'plans.name as plan_name', 'plans.price as plan_price', 'users.name as userName');
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('userName', function ($data) {
                return $data->userName;
            })
            ->addColumn('product', function ($data) {
                return $data->product_name;
            })
            ->addColumn('plan', function ($data) {
                return $data->plan_name;
            })
            ->addColumn('date', function ($data) {
                return $data->created_at?->format('Y-m-d');
            })
            ->addColumn('plan_price', function ($data) {
                return showPrice($data->plan_price);
            })
            ->addColumn('amount', function ($data) {
                return showPrice($data->amount);
            })
            ->rawColumns(['product', 'plan', 'date', 'amount'])
            ->make(true);
    }

    public function affiliateLink()
    {
        $affiliateIds = ['all', (string) auth()->id()];
        $affiliateConfigs = AffiliateConfig::query()
            ->where(function ($q) use ($affiliateIds) {
                foreach ($affiliateIds as $id) {
                    $q->orWhereJsonContains('affiliates', $id);
                }
            })
            ->where('user_id', auth()->user()->created_by)
            ->get();

        $productIds = [];
        $planIds = [];
        foreach ($affiliateConfigs as $affiliateConfig) {
            $productIds = array_unique(array_merge($productIds, array_values(json_decode($affiliateConfig->products))));
            $planIds = array_unique(array_merge($planIds, array_values(json_decode($affiliateConfig->plans))));
        }

        $data = Plan::query()
            ->join('products', 'plans.product_id', '=', 'products.id')
            ->where(function ($q) use ($productIds) {
                if (!in_array('all', $productIds)) {
                    $q->whereIn('plans.product_id', array_map('intval', $productIds));
                }
            })
            ->where(function ($q) use ($planIds) {
                if (!in_array('all', $planIds)) {
                    $q->whereIn('plans.id', array_map('intval', $planIds));
                }
            })
            ->where('plans.status', STATUS_ACTIVE)
            ->select('plans.*', 'products.name as product_name')
            ->get();

        return datatables($data)
            ->addIndexColumn()
            ->addColumn('product', function ($data) {
                return $data->product_name;
            })
            ->addColumn('plan', function ($data) {
                return $data->name;
            })
            ->addColumn('link', function ($data) {
                $checkoutData = ['plan_id' => $data->id, 'user_id' => $data->user_id, 'affiliate_code' => auth()->user()->affiliate_code];

                return '<a href="' . route('checkout', encrypt($checkoutData)) . '" class="text-break" target="_blank">' . route('checkout', encrypt($checkoutData)) . '</a>';
            })
            ->editColumn('action', function ($data) {
                $checkoutData = ['plan_id' => $data->id, 'user_id' => $data->user_id, 'affiliate_code' => auth()->user()->affiliate_code];
                return "<div class='d-flex justify-content-end align-items-center g-10'>
                            <button class='border-0 p-0 bg-transparent flex-shrink-0 copyLink' data-link='" . route('checkout', encrypt($checkoutData)) . "' ><img src='" . asset("user/images/icon/copy.svg") . "'> " . __('Copy to Clipboard') . "</button>
                        </div>";
            })
            ->rawColumns(['title', 'link', 'status', 'action'])
            ->make(true);
    }
}
