<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AffiliateConfigRequest;
use App\Http\Services\AffiliateService;
use App\Http\Services\SettingsService;
use App\Http\Services\WalletService;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    public $affiliateService, $settingsService, $walletService;

    public function __construct()
    {
        if (getOption('affiliate_status') != STATUS_ACTIVE) {
            abort(404);
        }
        $this->settingsService = new SettingsService();
        $this->affiliateService = new AffiliateService;
        $this->walletService = new WalletService();
    }

    public function index(Request $request)
    {
        $data['activeAffiliate'] = 'active';
        $data['pageTitle'] = __('Affiliates');
        $data['allProducts'] = $this->settingsService->getAllProduct();
        $data['allAffiliates'] = $this->affiliateService->getAll();
        if ($request->ajax()) {
            return $this->affiliateService->getAllData();
        }
        return view('user.affiliate.index', $data);
    }

    public function historyForUser(Request $request)
    {
        if ($request->ajax()) {
            return $this->affiliateService->affiliateHistoryDataForUser();
        }
        return view('user.affiliate.partials.history');
    }

    public function getInfo(Request $request)
    {
        return $this->affiliateService->getInfo($request->id);
    }

    public function statusChange(Request $request)
    {
        return $this->affiliateService->statusChange($request);
    }

    public function configStore(AffiliateConfigRequest $request)
    {
        return $this->affiliateService->configStore($request);
    }

    public function configList(Request $request)
    {
        if ($request->ajax()) {
            return $this->affiliateService->getConfigListData();
        }
    }

    public function configInfo(Request $request)
    {
        $data = $this->affiliateService->configInfo($request->id);
        if (!in_array('all', json_decode($data->products))) {
            $data->planByProducts = $this->settingsService->getPlanByProductIds(json_decode($data->products));
        } else {
            $data->planByProducts = [];
        }
        return $data;
    }

    public function configDelete($id)
    {
        return $this->affiliateService->configDeleteById($id);
    }


    public function withdrawRequestByStatus(Request $request)
    {
        if ($request->ajax()) {
            return $this->walletService->getWithdrawRequestByStatus($request);
        }
    }

    public function ordersEdit($id)
    {
        $data['withdraw'] =  $this->walletService->getWithdraw($id);
        return view('user.affiliate.partials.withdraw_request_status_edit', $data);
    }

    public function withdrawRequestStatusChange(Request $request)
    {
        return $this->walletService->withdrawRequestStatusChange($request);
    }
}
