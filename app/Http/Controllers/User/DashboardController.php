<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Services\DashboardService;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $data['activeDashboard'] = 'active';
        $data['pageTitle'] = __('Dashboard');
        $data['totalCustomer'] = User::where(['role' => USER_ROLE_CUSTOMER, 'created_by' => auth()->id()])->count();
        $data['totalSubscription'] = Subscription::where(['user_id'=> auth()->id(),  'status' => PAYMENT_STATUS_PAID])->count();
        $data['totalSubscriptionSales'] = Subscription::where(['user_id'=> auth()->id(),  'status' => PAYMENT_STATUS_PAID])->sum('amount');
        $data['monthlyRecurringRevenue'] = Invoice::where(['user_id' => auth()->id(), 'payment_status' => PAYMENT_STATUS_PAID])
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('amount');
        $data['totalSales'] = Order::where(['user_id'=> auth()->id(), 'payment_status' => PAYMENT_STATUS_PAID])->sum('total');
        $data['monthlySubscriber'] = $this->dashboardService->monthlySubscriber();
        $data['subscriptionyearList'] = Subscription::select(
            DB::raw("DATE_FORMAT(created_at, '%Y') year"))
            ->groupBy('year')
            ->distinct()
            ->get()
            ->toArray();
        $data['monthlyRevenue'] = $this->dashboardService->monthlyRevenue();
        $data['totalSalesAmountToday'] = Order::where('user_id', auth()->id())
            ->where('payment_status', PAYMENT_STATUS_PAID)
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');
        $data['totalSalesAmountYesterday'] = Order::where('user_id', auth()->id())
            ->where('payment_status', PAYMENT_STATUS_PAID)
            ->whereDate('created_at', Carbon::yesterday())
            ->sum('amount');
        $data['dailyAverage'] = ($data['totalSalesAmountToday'] + $data['totalSalesAmountYesterday']) * 0.5;

        $data['TopSellingPlans'] = Subscription::leftjoin('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->leftjoin('users', 'subscriptions.customer_id', '=', 'users.id')
            ->select(DB::raw('COUNT(subscriptions.id) as plan_count'), 'subscriptions.plan_id as plan', 'plans.name as plan_name', 'users.email as users_email')
            ->groupBy('subscriptions.plan_id')
            ->orderBy('plan_count', 'DESC')
            ->take(2)
            ->get();
        return view('user.dashboard.dashboard', $data);
    }

    public function monthlySubscriber(Request $request)
    {
        $data['monthlySubscriber'] = $this->dashboardService->monthlySubscriber($request->year);
        return view('user.dashboard.monthly_subscriber', $data)->render();
    }

    public function monthlyRevenue(Request $request)
    {
        $data['monthlyRevenue'] = $this->dashboardService->monthlyRevenue($request->year);
        return view('user.dashboard.monthly_revenue', $data)->render();
    }

    public function productSoldOutChartData(Request $request)
    {
        return $this->dashboardService->productSoldOutChartData($request, USER_ROLE_USER);
    }
    public function dailySubscriberChartData(Request $request)
    {
        return $this->dashboardService->dailySubscriberChartData($request, USER_ROLE_USER);
    }

}
