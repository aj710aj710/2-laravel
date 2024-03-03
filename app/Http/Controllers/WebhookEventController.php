<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Product;
use App\Models\WebhookEvent;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebhookEventController extends Controller
{
    use ResponseTrait;

    public function events(Request $request){
        if ($request->ajax()) {

            $event = WebhookEvent::where('user_id', auth()->id());
            if ($request->plan_id != null) {
                $event->where('webhook_events.plan_id', $request->plan_id);
            }

            return datatables($event)
                ->addIndexColumn()
                ->addColumn('event_type', function ($data) {
                    if($data->event_type == WEBHOOK_EVENT_TYPE_PAYMENT){
                        return 'Payment';
                    }
                })
                ->addColumn('product_name', function ($data) {
                    return $data->product->name;
                })

                ->addColumn('plan_name', function ($data) {
                    return $data->plan->name;
                })

                ->addColumn('status', function ($data) {
                    if ($data->status == WEBHOOK_EVENT_STATUS_SUCCESS) {
                        return '<span class="text-success">Success</span>';
                    } else if($data->status == WEBHOOK_EVENT_STATUS_PENDING) {
                        return '<span class="text-warning">Pending</span>';
                    }else{
                        return '<span class="text-danger">Failed</span>';
                    }
                })
                ->addColumn('created_at', function ($data) {
                    return date('d-m-Y H:m:s', strtotime($data->created_at));
                })
                ->rawColumns(['status','created_at'])
                ->make(true);
        }

        $user=Auth::id();
        $data['pageTitle'] = __('Webhook Events');
        $data['activeWebhookEvents'] = 'active';
        $data['product'] = Product::where('status', STATUS_ACTIVE)
            ->where('user_id', $user)
            ->get();
        return view('user.webhook_event.index', $data);
    }
    public function getPlanData(Request $request)
    {
        $data['plan'] = Plan::where('product_id', $request->id)->get();
        return $this->success(view('user.subscription.plan-render', $data)->render());

    }

}
