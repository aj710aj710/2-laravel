<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutOrderPlaceRequest;
use App\Http\Services\CheckoutService;
use App\Http\Services\GatewayService;
use App\Http\Services\PlanService;
use App\Http\Services\SettingsService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    use ResponseTrait;
    public $settingsService, $gatewayService, $checkoutService, $planService;

    public function __construct()
    {
        $this->settingsService = new SettingsService();
        $this->gatewayService = new GatewayService();
        $this->checkoutService = new CheckoutService();
        $this->planService = new PlanService();
    }

    public function checkout($hash)
    {
        $paramData = decrypt($hash);
        $data['plan'] = $this->planService->details($paramData['plan_id'], $paramData['user_id']);
        if (!$data['plan']) {
            return back()->with('error', __(SOMETHING_WENT_WRONG));
        }
        $data['pageTitle'] = __('Checkout');
        $data['checkoutPage'] = $this->settingsService->checkoutPageSettingByUserId($paramData['user_id']);
        $data['gateways'] = $this->gatewayService->getActiveAll($paramData['user_id']);
        $data['banks'] = $this->gatewayService->getActiveBanks($paramData['user_id']);

        return view('frontend.checkout', $data);
    }

    public function checkoutOrder(CheckoutOrderPlaceRequest $request)
    {
        return $this->checkoutService->checkoutOrder($request);
    }

    public function getCurrencyByGateway(Request $request)
    {
        $data =  $this->checkoutService->getCurrencyByGatewayId($request->id);
        return $this->success($data);
    }

    public function getCouponInfo(Request $request)
    {
        return $this->settingsService->getCouponInfo($request);
    }
}
