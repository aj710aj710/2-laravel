<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\WebhookRequest;
use App\Http\Services\GatewayService;
use App\Http\Services\PlanService;
use App\Http\Services\SettingsService;
use App\Models\Webhook;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class WebhookController extends Controller
{
    use ResponseTrait;


    public $planService, $settingsService, $gatewayService;

    public function __construct()
    {
        $this->planService = new PlanService();
        $this->settingsService = new SettingsService();
        $this->gatewayService = new GatewayService();
    }

    public function webhookList(Request $request){

        if ($request->ajax()) {
            $tax = Webhook::where('user_id', auth()->id())->with(['plan', 'product']);
            return datatables($tax)
                ->addIndexColumn()

                ->addColumn('product_name', function ($data) {
                    return htmlspecialchars($data->product->name);
                })

                ->addColumn('plan_name', function ($data) {
                    return htmlspecialchars($data->plan->name);
                })

                ->addColumn('status', function ($data) {
                    if ($data->status == STATUS_ACTIVE) {
                        return '<span class="zBadge-free">Active</span>';
                    } else {
                        return '<span class="zBadge-free">Inactive</span>';
                    }
                })
                ->addColumn('action', function ($data){
                    return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                            <li class="d-flex gap-2">
                                <button onclick="getEditModal(\'' . route('user.webhook.edit', $data->id) . '\'' . ', \'#edit-webhook-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one border-0 bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="Edit">
                                    <img src="' . asset('assets/images/icon/edit.svg') . '" alt="edit" />
                                </button>
                                <button onclick="deleteItem(\'' . route('user.webhook.delete', $data->id) . '\', \'webhookTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle border-0 bd-one bd-c-ededed bg-white" title="Delete">
                                    <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                                </button>
                            </li>
                        </ul>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    }
    public function webhookStore(WebhookRequest $request){
        try {
            DB::beginTransaction();
            if(isset($request->id)){
                $data = Webhook::find($request->id);
                $msg = UPDATED_SUCCESSFULLY;
            }else{
                $data = new Webhook();
                $msg = CREATED_SUCCESSFULLY;
            }

            $data->webhook_name = $request->webhook_name;
            $data->product_id = $request->product_id;
            $data->plan_id = $request->plan_id;
            $data->webhook_url = $request->webhook_url;
            $data->user_id = auth()->id();
            $data->status = STATUS_ACTIVE;
            $data->save();
            DB::commit();
            return $this->success([], getMessage($msg));
        }catch (Exception $exception){
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function deleteWebhook($id){
        try {
            $event = Webhook::where('id', $id)->first();
            $event->delete();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function webhookEdit($id)
    {
        try {
            $data['webhook'] = Webhook::find($id);
            if (is_null($data['webhook'])){
                return $this->error([], getMessage(SOMETHING_WENT_WRONG));
            }
            $data['allProducts'] = $this->settingsService->getAllProduct();
            $data['planList'] = $this->planService->planListByProductId($data['webhook']->product_id);
            return view('user.settings.webhook.edit-form', $data)->render();
        }catch (Exception $exception){
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }
}
