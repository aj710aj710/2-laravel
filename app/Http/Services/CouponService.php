<?php

namespace App\Http\Services;

use App\Models\Coupon;
use App\Traits\ResponseTrait;

class CouponService
{
    use ResponseTrait;

    public function list($id)
    {
        $plan = Coupon::where(['product_id' => $id, 'user_id'=> auth()->id()]);
        return datatables($plan)
            ->addIndexColumn()
            ->addColumn('discount', function ($data) {
                if ($data->discount_type == DISCOUNT_TYPE_FLAT) {
                    return '<p>'.getCurrencyPlacement().$data->discount.'</p>';
                }else{
                    return '<p>'.$data->discount.'%'.'</p>';
                }
            })
            ->addColumn('redemption_type', function ($data) {
                if ($data->redemption_type == REDEMPTION_TYPE_ONETIME) {
                    return "<p class='zBadge zBadge-active'>".__('One Time')."</p>";
                } elseif($data->redemption_type == REDEMPTION_TYPE_FOREVER){
                    return "<p class='zBadge zBadge-active'>".__('Forever')."</p>";
                }elseif($data->redemption_type == REDEMPTION_TYPE_LIMITED_NUMBER){
                    return "<p class='zBadge zBadge-active'>".__('Limited Numbers')."</p>";
                }
            })
            ->addColumn('valid_date', function ($data) {
                return "<p>".date('d-m-Y', strtotime($data->valid_date))."</p>";
            })
            ->addColumn('action', function ($data) {
                return "
                <div class='d-flex justify-content-end align-items-center g-10'>
                <button class='border-0 p-0 bg-transparent flex-shrink-0' onclick='getEditModal(\"" . route("user.coupon.edit", encrypt($data->id)) . "\"" . ", \"#editCouponModal\")'><img src='".asset('user')."/images/icon/edit.svg' alt=''></button>
                <button class='border-0 p-0 bg-transparent flex-shrink-0' onclick='deleteItem(\"" . route("user.coupon.delete", encrypt($data->id)) . "\", \"couponDetailsTable\")'><img src='".asset('user')."/images/icon/delete.svg' alt=''></button>
                </div>";
            })
            ->rawColumns(['discount', 'redemption_type', 'action', 'valid_date'])
            ->make(true);
    }
}
