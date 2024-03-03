<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Product;
use App\Models\Subscription;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
}
