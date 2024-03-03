<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Http\Services\AffiliateService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public $affiliateService;

    public function __construct()
    {
        $this->affiliateService = new AffiliateService;
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = __('Dashboard');
        $data['activeAffiliateDashboard'] = 'active';
        $data['totalCommission'] = $this->affiliateService->getAllAffiliateHistory(auth()->id())->sum('amount');
        $data['availableBalance'] = auth()->user()->affiliate_commission_amount;
        $data['totalAffiliate'] = $this->affiliateService->getAllAffiliateHistory(auth()->id())->count();
        $data['totalLink'] = $this->affiliateService->getAllConfig()->count();
        $data['affiliateHistoryMonthlyChartData'] = $this->affiliateService->affiliateHistoryMonthlyChartData(auth()->id());
        return view('affiliate.dashboard', $data);
    }
}
