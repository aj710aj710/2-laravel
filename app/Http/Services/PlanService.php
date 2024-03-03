<?php

namespace App\Http\Services;

use App\Models\Plan;
use App\Traits\ResponseTrait;

class PlanService
{
    use ResponseTrait;

    public function list($id)
    {
        $plan = Plan::where(['product_id' => $id, 'user_id' => auth()->id()]);
        return datatables($plan)
            ->addIndexColumn()
            ->addColumn('billing_cycle', function ($data) {
                if ($data->billing_cycle == BILLING_CYCLE_ONETIME) {
                    return '<p>One Time</p>';
                } elseif ($data->billing_cycle == BILLING_CYCLE_AUTO_RENEW) {
                    return '<p>Auto renews until cancelled</p>';
                } elseif ($data->billing_cycle == BILLING_CYCLE_EXPIRE_AFTER) {
                    return '<p>Expire after a specified no. of billing cycle</p>';
                }
            })
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return "<p class='zBadge zBadge-active'>".__('Active')."</p>";
                } else {
                    return "<p class='zBadge zBadge-fuilure'>".__('Inactive')."</p>";
                }
            })
            ->addColumn('price', function ($data) {
                return getCurrencyPlacement() . $data->price;
            })
            ->addColumn('action', function ($data) {
                $checkoutData = ['plan_id' => $data->id, 'user_id' => $data->user_id];
                return "<div class='d-flex justify-content-end align-items-center g-10'>
                            <a href='" . route('checkout', encrypt($checkoutData)) . "' class='fs-14 fw-500 lh-17 text-main-color text-decoration-underline flex-shrink-0'>".__('Continue To Checkout')."</a>
                            <button class='border-0 p-0 bg-transparent flex-shrink-0 shareModal' onclick='getEditModal(\"" . route("user.plan.share", encrypt($checkoutData)) . "\"" . ", \"#editPlanModal\")'>
                                <img src='" . asset('user') . "/images/icon/share-2.svg' alt=''>
                            </button>
                            <button class='border-0 p-0 bg-transparent flex-shrink-0' onclick='getEditModal(\"" . route("user.plan.edit", encrypt($data->id)) . "\"" . ", \"#editPlanModal\")'><img src='" . asset('user') . "/images/icon/edit.svg' alt=''></button>
                            <button class='border-0 p-0 bg-transparent flex-shrink-0' onclick='deleteItem(\"" . route("user.plan.delete", encrypt($data->id)) . "\", \"planDetailsTable\")'><img src='" . asset('user') . "/images/icon/delete.svg' alt=''></button>
                        </div>";
            })
            ->rawColumns(['billing_cycle', 'price', 'action', 'status'])
            ->make(true);
    }

    public function details($id, $userId)
    {
        return Plan::where('user_id', $userId)->find($id);
    }

    public function planListByProductId($productId)
    {
        return Plan::where('product_id', $productId)->get();
    }
}
