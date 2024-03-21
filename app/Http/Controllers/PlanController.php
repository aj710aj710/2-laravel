<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Mockery\Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Services\PlanService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\User\PlanRequest;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    use ResponseTrait;

    protected $plan;

    public function __construct()
    {
        $this->plan = new PlanService();
    }

    public function list($id, Request $request)
    {
        if ($request->ajax()) {
            return $this->plan->list($id);
        }
        try {
            $productInfo = Product::find(decrypt($id));
            if (is_null($productInfo)) {
                return $this->error([], getMessage(SOMETHING_WENT_WRONG));
            }
        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }

        $data['pageTitle'] = __('Plan List For - ') . $productInfo->name;
        $data['activeProduct'] = 'active';
        $data['productInfo'] = $productInfo;
        return view('user.plan.list', $data);
    }

    public function listForDropdown(Request $request)
    {
        $data['plans'] = Plan::where(['product_id' => decrypt($request->product_id), 'user_id' => auth()->id()])->get();
        return view('user.plan.list_for_dropdown', $data);
    }

    public function store(PlanRequest $request)
    {
        try {
            DB::beginTransaction();
            if (isset($request->id)) {
                $plan = Plan::find(decrypt($request->id));
                $msg = UPDATED_SUCCESSFULLY;
            } else {
                $plan = new Plan();
                $plan->product_id = decrypt($request->product_id);
                $msg = CREATED_SUCCESSFULLY;
            }

            $plan->name = $request->name;
            $plan->code = $request->code;
            $plan->price = $request->price;
            $plan->due_day = $request->due_day;
            $plan->billing_cycle = $request->billing_cycle;
            $plan->bill = $request->bill ?? 0;
            $plan->shipping_charge = $request->shipping_charge ?? 0;
            $plan->duration = $request->duration ?? 0;
            $plan->number_of_recurring_cycle = $request->number_of_recurring_cycle ?? 0;
            $plan->status = $request->status;
            $plan->free_trail = $request->free_trail ?? 0;
            $plan->setup_fee = $request->setup_fee ?? 0;
            $plan->user_id = auth()->id();
            $plan->details = $request->details;
            $plan->save();
            DB::commit();
            return $this->success([], getMessage($msg));
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function delete($id)
    {
        try {
            $id = decrypt($id);
            $data = Plan::find($id);
            $data->delete();
            return $this->success([], getMessage(DELETED_SUCCESSFULLY));
        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function edit($id)
    {
        try {
            $data['plan'] = Plan::find(decrypt($id));
            if (is_null($data['plan'])) {
                return $this->error([], getMessage(SOMETHING_WENT_WRONG));
            }
            return view('user.plan.edit-form', $data)->render();
        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function share($id)
    {
        try {
            $data['plan'] = Plan::find(decrypt($id));
            if (is_null($data['plan'])) {
                return $this->error([], getMessage(SOMETHING_WENT_WRONG));
            }
            $data['checkout_url'] = route('checkout', $id);
            $data['embed_code'] = '<script src="'.url('/').'/api/checkout/embed.js?embed_code='.$id.'"></script>';
            $data['fb_share'] = 'http://www.facebook.com/sharer/sharer.php?u='.$data['checkout_url'];
            $data['tw_share'] = 'http://www.twitter.com/share?url='.$data['checkout_url'];
            return view('user.plan.share', $data)->render();
        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }
    public function index()
    {
        $plans = Plan::all();
        return response()->json([
            'status' => 200,
            'plans' => $plans
        ],200);
     }

      public function upload(Request $request)
      {
        $validator = Validator::make($request->all(),[
            'product_id'=> 'required',
            'name'=> 'required',
            'code'=> 'required',
            'due_day'=> 'required',
            'price'=> 'required',
            'billing_cycle'=> 'required',
            'shipping_charge'=> 'required',
            'bill'=> 'required',
            'duration'=> 'required',
            'number_of_recurring_cycle'=> 'required',
            'status'=> 'required',
            'free_trail'=> 'required',
            'setup_fee'=> 'required',
           
        ]);
        if($validator->fails())
        {
         $data=[
             'status'=> 422,
             'message'=> $validator->messages()
         ];
         return response()->json($data,422);
        }else{
         $plans = new Plan;
         $plans->product_id=$request->product_id;
         $plans->name=$request->name;
         $plans->code=$request->code;
         $plans->due_day=$request->due_day;
         $plans->price=$request->price;
         $plans->billing_cycle=$request->billing_cycle;
         $plans->shipping_charge=$request->shipping_charge;
         $plans->bill=$request->bill;
         $plans->duration=$request->duration;
         $plans->number_of_recurring_cycle=$request->number_of_recurring_cycle;
         $plans->status=$request->status;
         $plans->free_trail=$request->free_trail;
         $plans->setup_fee=$request->setup_fee;
         
         $plans->save();
         $data=[
            'status'=> 200,
            'message'=>'Data uploaded successfully'
         ];
         return response()->json($data,200);
        }
      }
}
