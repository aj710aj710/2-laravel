<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LicenseRequest;
use App\Http\Services\LicenseService;
use App\Models\License;
use App\Models\Plan;
use App\Models\Product;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class licenseController extends Controller
{
    use ResponseTrait;

    protected $license;
    public function __construct()
    {
        $this->license = new LicenseService();
    }

    public function list($id,Request $request){
        if ($request->ajax()) {
            return $this->license->list($id);
        }
        try {
            $productInfo = Product::find(decrypt($id));
            if(is_null($productInfo)){
                return $this->error([], getMessage(SOMETHING_WENT_WRONG));
            }
        }catch (Exception $exception){
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }

        $data['pageTitle'] = __('License List For - ').$productInfo->name;
        $data['activeProduct'] = 'active';
        $data['productInfo'] = $productInfo;
        return view('user.license.list', $data);
    }

    public function store(LicenseRequest $request){
        try {
            DB::beginTransaction();
            $planExistOrNot = License::where('product_plan', $request->product_plan)->first();

            if(isset($request->id)){
                $data = License::find(decrypt($request->id));
                $msg = UPDATED_SUCCESSFULLY;
            }else{
                if(!is_null($planExistOrNot)){
                    return $this->error([], __("License already exist!"));
                }
                $data = new License();
                $data->product_id = decrypt($request->product_id);
                $msg = CREATED_SUCCESSFULLY;
            }
            $data->name = $request->name;
            $data->code = $request->code;
            $data->product_plan = $request->product_plan;
            $data->status = $request->status;
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
            $data = License::find($id);
            $data->delete();
            return $this->success([], getMessage(DELETED_SUCCESSFULLY));
        }catch (Exception $exception){
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }
    public function edit($id){
        try {
            $data['license'] = License::find(decrypt($id));
            if (is_null($data['license'])){
                return $this->error([], getMessage(SOMETHING_WENT_WRONG));
            }
            $data['planList'] = Plan::where('product_id', $data['license']->product_id)->get();
            return view('user.license.edit-form', $data)->render();
        }catch (Exception $exception){
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }
}
