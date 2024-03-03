<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Http\Services\AffiliateService;
use App\Http\Services\BeneficiaryService;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    public $affiliateService;

    public function __construct()
    {
        $this->affiliateService = new AffiliateService;
    }

    public function link(Request $request)
    {
        $data['pageTitle'] = __('Link');
        $data['activeAffiliateLink'] = 'active';
        if ($request->ajax()) {
            return $this->affiliateService->affiliateLink();
        }
        return view('affiliate.link', $data);
    }

    public function history(Request $request)
    {
        $data['pageTitle'] = __('History');
        $data['activeAffiliateHistory'] = 'active';
        if ($request->ajax()) {
            return $this->affiliateService->affiliateHistoryData();
        }
        return view('affiliate.history', $data);
    }

    public function wallet(Request $request)
    {
        $data['pageTitle'] = __('My Wallet');
        $data['activeWallet'] = 'active';
        if ($request->ajax()) {
            return $this->affiliateService->affiliateTransactionData(auth()->id());
        }
        $beneficiaryService = new BeneficiaryService();
        $data['beneficiaries'] = $beneficiaryService->getUserBeneficiary();
        return view('affiliate.wallet.index', $data);
    }
}
