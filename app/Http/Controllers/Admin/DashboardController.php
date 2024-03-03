<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\DashboardService;
use App\Models\Invoice;
use App\Models\Subscription;
use App\Models\User;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    use ResponseTrait;

    public $dashboardService;

    public function __construct()
    {
        $this->dashboardService = new DashboardService();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return '';
        }
        $data['pageTitle'] = __('Dashboard');
        $data['activeDashboard'] = 'active';
        $data['totalUser'] = User::where(['role' => USER_ROLE_USER, 'status' => STATUS_ACTIVE])->count();
        $data['totalCustomer'] = User::where(['role' => USER_ROLE_CUSTOMER, 'status' => STATUS_ACTIVE])->count();
        $data['totalSubscription'] = Subscription::where(['status' => PAYMENT_STATUS_PAID])->count();
        $data['monthlyRecurringRevenue'] = Invoice::where(['payment_status' => PAYMENT_STATUS_PAID])
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('amount');
        return view('admin.dashboard', $data);
    }

    public function productSoldOutChartData(Request $request)
    {
        return $this->dashboardService->productSoldOutChartData($request);
    }

    public function dailySubscriberChartData(Request $request)
    {
        return $this->dashboardService->dailySubscriberChartData($request);
    }

}
