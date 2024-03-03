<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CouponRequest;
use App\Http\Services\CouponService;
use App\Models\Coupon;
use App\Models\Plan;
use App\Models\Product;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class CouponController extends Controller
{
    use ResponseTrait;

    protected $coupon;
    public function __construct()
    {
        $this->coupon = new CouponService();
    }

    public function list($id,Request $request){
        if ($request->ajax()) {
            return $this->coupon->list($id);
        }
        try {
            $productInfo = Product::find(decrypt($id));
            if(is_null($productInfo)){
                return $this->error([], getMessage(SOMETHING_WENT_WRONG));
            }
        }catch (Exception $exception){
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }

        $data['pageTitle'] = __('Coupon List For - ').$productInfo->name;
        $data['activeProduct'] = 'active';
        $data['productInfo'] = $productInfo;
        return view('user.coupon.list', $data);
    }

    public function store(CouponRequest $request){
        try {
            DB::beginTransaction();
            if(isset($request->id)){
                $data = Coupon::find(decrypt($request->id));
                $msg = UPDATED_SUCCESSFULLY;
            }else{
                $data = new Coupon();
                $data->product_id = decrypt($request->product_id);
                $msg = CREATED_SUCCESSFULLY;
            }

            $data->name = $request->coupon_name;
            $data->code = $request->coupon_code;
            $data->discount_type = $request->discount_type;
            $data->discount = $request->discount;
            $data->redemption_type = $request->redemption_type;
            $data->product_plan = $request->product_plan;
            $data->valid_date = $request->valid_date;
            $data->maximum_redemption = $request->maximum_redemption??0;
            $data->user_id = auth()->id();
            $data->save();
            DB::commit();
            return $this->success([], getMessage($msg));
        }catch (Exception $exception){
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }
    public function delete($id){
        try {
            $id = decrypt($id);
            $data = Coupon::find($id);
            $data->delete();
            return $this->success([], getMessage(DELETED_SUCCESSFULLY));
        }catch (Exception $exception){
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }
    public function edit($id){
        try {
            $data['coupon'] = Coupon::find(decrypt($id));
            if (is_null($data['coupon'])){
                return $this->error([], getMessage(SOMETHING_WENT_WRONG));
            }
            $data['planList'] = Plan::where('product_id', $data['coupon']->product_id)->get();
            return view('user.coupon.edit-form', $data)->render();
        }catch (Exception $exception){
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }
}
