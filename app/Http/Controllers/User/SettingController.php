<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutPageSettingRequest;
use App\Http\Requests\User\TaxSettingRequest;
use App\Http\Services\GatewayService;
use App\Http\Services\SettingsService;
use App\Http\Services\UserService;
use App\Models\Plan;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;


class SettingController extends Controller
{
    use ResponseTrait;

    public $userService, $settingsService, $gatewayService;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->settingsService = new SettingsService();
        $this->gatewayService = new GatewayService();
    }

    public function settings(Request $request)
    {
        $data['activeSetting'] = 'active';
        $data['pageTitle'] = __('Settings');
        $data['user'] = $this->userService->userData();
        $data['checkoutPage'] = $this->settingsService->checkoutPageSetting();
        $data['gateways'] = $this->gatewayService->getActiveAll(auth()->id());
        $data['allProducts'] = $this->settingsService->getAllProduct();
        $data['invoiceSetting'] = $this->settingsService->invoiceSettingInfo();
        if ($request->ajax()) {
            return $this->settingsService->taxList();
        }
        return view('user.settings.settings', $data);
    }

    public function changePasswordUpdate(Request $request)
    {
        return $this->userService->changePasswordUpdate($request);
    }

    public function settingUpdate(Request $request)
    {
        return $this->userService->settingUpdate($request);
    }

    public function emailTemplateConfig(Request $request)
    {
        return $this->settingsService->emailTemplateConfig($request);
    }

    public function emailTemplateConfigUpdate(Request $request)
    {
        return $this->settingsService->emailTemplateConfigUpdate($request);
    }

    public function emailTemplateStatus(Request $request)
    {
        return $this->settingsService->emailTemplateStatus($request);
    }

    public function emailTest(Request $request)
    {
        return $this->settingsService->emailTest($request);
    }

    // checkout page setting
    public function checkoutPageUpdate(CheckoutPageSettingRequest $request)
    {
        return $this->settingsService->checkoutPageUpdate($request);
    }

    public function invoiceUpdate(Request $request)
    {
        return $this->settingsService->invoiceUpdate($request);
    }

    public function getPlanData(Request $request)
    {
        $data['plan'] =  $this->settingsService->getPlan($request->id);
        return $this->success(view('user.settings.tax.select-plan-render', $data)->render());
    }

    public function getPlanByProduct(Request $request)
    {
        return $this->settingsService->getPlanByProductIds($request->ids);
    }

    public function taxStore(TaxSettingRequest $request)
    {
        return $this->settingsService->taxDataStore($request);
    }

    public function taxEdit($id)
    {
        $data['tax'] =  $this->settingsService->taxDataEdit($id);
        $data['planList'] =  Plan::where('product_id', $data['tax']->product_id)->get();
        $data['allProducts'] = $this->settingsService->getAllProduct();
        return view('user.settings.tax.tax-edit', $data);
    }

    public function deleteTax($id)
    {
        return $this->settingsService->taxDataDelete($id);
    }
}
