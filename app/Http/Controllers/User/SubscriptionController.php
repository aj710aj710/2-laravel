<?php

namespace App\Http\Controllers\User;

use App\Models\Plan;
use App\Models\Product;
use App\Mail\Websitemail;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class SubscriptionController extends Controller
{
    use ResponseTrait;

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::id();
            $subscription = Subscription::leftJoin('products', 'subscriptions.product_id', '=', 'products.id')
                ->leftJoin('plans', 'subscriptions.plan_id', '=', 'plans.id')
                ->leftJoin('users', 'subscriptions.customer_id', '=', 'users.id')
                ->where(['subscriptions.user_id' => $user])
                ->select(
                    'products.name as product_name', 'plans.name as plan_name',
                    'users.email as customer_email',
                    'subscriptions.*')
               ->orderBy('subscriptions.id','desc');
            if ($request->plan_id != null) {
                $subscription->where('plan_id', $request->plan_id);
            }
            return datatables($subscription)
                ->addColumn('product_name', function ($data) {
                    return $data->product_name;
                })
                ->addColumn('email', function ($data) {
                    return $data->customer_email;
                })
                ->addColumn('plan', function ($data) {
                    return $data->plan->name;
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == STATUS_ACTIVE) {
                        return "<p class='zBadge zBadge-active'>" . __('Paid') . "</p>";
                    }elseif($data->status == STATUS_CANCELED){
                        return "<p class='zBadge zBadge-fuilure'>" . __('Canceled') . "</p>";
                    } else {
                        return "<p class='zBadge zBadge-pending'>" . __('Pending') . "</p>";
                    }
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        $user = Auth::id();
        $data['pageTitle'] = __('Subscription History');
        $data['activeSubscriptionList'] = 'active';
        $data['product'] = Product::where('status', STATUS_ACTIVE)
            ->where('user_id', $user)
            ->get();
        return view('user.subscription.index', $data);
    }

    public function getPlanData(Request $request)
    {
        $data['plan'] = Plan::where('product_id', $request->id)->get();
        return $this->success(view('user.subscription.plan-render', $data)->render());
    }

    public function subscription($hash)
    {
        $paramData = decrypt($hash);
    }

    public function uploadsubscriptions(Request $request)
    {
      $validator = Validator::make($request->all(),[
          'product_id'=> 'required',
          
          'plan_id'=> 'required',
          'subscription_id'=> 'required',
          'license'=> 'required',
          'user_id'=> 'required',
          'customer_id'=> 'required',
          'start_date'=> 'required',
          'end_date'=> 'required',
          'due_day'=> 'required',
          'amount'=> 'required',
          'free_trail'=> 'required',
          'setup_fee'=> 'required',
          'billing_cycle'=> 'required',
          'bill'=> 'required',
          'duration'=> 'required',
          'number_of_recurring_cycle'=> 'required',
          'shipping_charge'=> 'required',
          'status'=> 'required',
          'deleted_at'=> 'required',
      ]);
      if($validator->fails())
      {
       $data=[
           'status'=> 422,
           'message'=> $validator->messages()
       ];
       return response()->json($data,422);
      }else{
       $subscriptions = new Subscription;
       $subscriptions->product_id=$request->product_id;
       $subscriptions->plan_id=$request->plan_id;
       $subscriptions->subscription_id=$request->subscription_id;
       $subscriptions->license=$request->license;
       $subscriptions->user_id=$request->user_id;
       $subscriptions->customer_id=$request->customer_id;
       $subscriptions->start_date=$request->start_date;
       $subscriptions->end_date=$request->end_date;
       $subscriptions->due_day=$request->due_day;
       $subscriptions->amount=$request->amount;
       $subscriptions->free_trail=$request->free_trail;
       $subscriptions->setup_fee=$request->setup_fee;
       $subscriptions->billing_cycle=$request->billing_cycle;
       $subscriptions->bill=$request->bill;
       $subscriptions->duration=$request->duration;
       $subscriptions->number_of_recurring_cycle=$request->number_of_recurring_cycle;
       $subscriptions->shipping_charge=$request->shipping_charge;
       $subscriptions->status=$request->status;
       $subscriptions->deleted_at=$request->deleted_at;
       
       
       $subscriptions->save();
       $data=[
          'status'=> 200,
          'message'=>'Data uploaded successfully'
       ];
       return response()->json($data,200);
      }
    }
    public function uploadsubscribers(Request $request)
    {
            $validated = $request->validate([
                'email' => 'required|email|max:30']);

        // else
        // {

 
            // Send email
            $subject = 'Subscription Confirmation';
            $view = view('emails.welcome_email');
            $message = 'Please click on the following link in order to verify as subscriber:<br><br>';
            
            

            $message .= $view;

            \Mail::to($request->email)->send(new Websitemail($subject,$message));
            $data=[
                'status'=> 200,
                'message'=>'Successfully Mail Send'
             ];
             return response()->json($data,200);
            return redirect()->back()->with('success', 'Thanks, please check your inbox to confirm subscription');
        // }
    }
}
