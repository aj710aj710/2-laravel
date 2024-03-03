<?php


namespace App\Http\Services;

use App\Models\Subscription;
use App\Models\User;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    use ResponseTrait;

    public function dashboardDailyMembershipPaymentChart()
    {
        $first_day_of_the_current_month = Carbon::now()->startOfMonth();
        $current_month_days_count = $first_day_of_the_current_month->diff(now());
        $last_day_of_the_current_month = Carbon::now()->endOfMonth();
        $price = [];
        $membershipChartData['mainData'] = [];
        $membershipChartData['days'] = [];
        $membershipChartData['price'] = $price;
        $membershipChartData['current_month_days_count'] = $current_month_days_count->d;
        return $membershipChartData;
    }

    public function dashboardTopEventTicketChart()
    {
        $eventTicketData['mainData'] = [];
        $eventTicketData['totalTicket'] = [];
        $eventTicketData['eventName'] = [];
        return $eventTicketData;
    }

    public function monthlySubscriber($selectedYear = null)
    {
        $year = $selectedYear != null ? $selectedYear : Carbon::now()->year;
        return Subscription::select(
            DB::raw("DATE_FORMAT(created_at, '%Y') year"),
            DB::raw("DATE_FORMAT(created_at, '%b') month"),
            DB::raw('count(id) as subscriber'))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get()
            ->toArray();
    }

    public function monthlyRevenue($selectedYear = null)
    {
        $year = $selectedYear != null ? $selectedYear : Carbon::now()->year;
        return Subscription::select(
            DB::raw("DATE_FORMAT(created_at, '%b') month"),
            DB::raw('sum(amount) as revenue'))
            ->whereYear('created_at', $year)
            ->where('status', PAYMENT_STATUS_PAID)
            ->groupBy('month')
            ->get()
            ->toArray();
    }

    public function productSoldOutChartData($request, $user_type=null)
    {
        try {
            $year = $request->year != null ? $request->year : Carbon::now()->year;

            $subscriptionData = Subscription::select(
                DB::raw("DATE_FORMAT(created_at, '%b') month"),
                DB::raw('count(id) as product'))
                ->whereYear('created_at', $year)
                ->where(['status'=> PAYMENT_STATUS_PAID])
                ->where(function ($data) use ($user_type){
                    if ($user_type == USER_ROLE_USER) {
                        $data->where(['user_id'=> auth()->id()]);
                    }
                })
                ->groupBy('month')
                ->get()
                ->toArray();

            $chatData = [];
            $year = Carbon::now()->year;
            $monthList = [];

            for ($month = 1; $month <= 12; $month++) {
                $monthName = Carbon::create($year, $month, 1)->format('M');
                $monthList[$month] = $monthName;
            }

            $chatData = [];
            foreach ($monthList as $month) {
                $chatData[$month] = 0;
            }
            foreach ($subscriptionData as $data) {
                $chatData[$data['month']] = $data['product'];
            }

            return  $this->success($chatData, 'Data Found');
        }catch (\Exception $exception){
            return $this->error([], $exception->getMessage());
        }

    }

    public function dailySubscriberChartData($request, $user_type=null)
    {
        try {
            $startWeek = Carbon::now()->subWeek()->startOfDay();
            $endWeek   = Carbon::now()->subWeek()->endOfDay();
            $previousWeekSubscriber = User::select(
                DB::raw('count(id) as user'))
                ->whereBetween('created_at',
                    [$startWeek, $endWeek]
                )
                ->where(['role'=> USER_ROLE_CUSTOMER, 'status'=> USER_STATUS_ACTIVE])
                ->where(function ($data) use ($user_type){
                    if ($user_type == USER_ROLE_USER) {
                        $data->where(['created_by'=> auth()->id()]);
                    }
                })
                ->count();

            $currentWeekSubscriber = User::select(
                DB::raw('count(id) as user'))
                ->whereBetween('created_at',
                    [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()]
                )
                ->where(['role'=> USER_ROLE_CUSTOMER, 'status'=> USER_STATUS_ACTIVE])
                ->where(function ($data) use ($user_type){
                    if ($user_type == USER_ROLE_USER) {
                        $data->where(['created_by'=> auth()->id()]);
                    }
                })
                ->count();

            $rationOfUserActiveChart = 0;
            if($previousWeekSubscriber != 0 && $currentWeekSubscriber != 0){
                $rationOfUserActiveChart = (($currentWeekSubscriber-$previousWeekSubscriber)/ $currentWeekSubscriber)*100;
            }

            $dailyUser = User::select(
                DB::raw("DATE_FORMAT(created_at, '%a') day"),
                DB::raw('count(id) as user'))
                ->whereBetween('created_at',
                    [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
                )
                ->where(['role'=> USER_ROLE_CUSTOMER, 'status'=> USER_STATUS_ACTIVE])
                ->where(function ($data) use ($user_type){
                    if ($user_type == USER_ROLE_USER) {
                        $data->where(['created_by'=> auth()->id()]);
                    }
                })
                ->groupBy('day')
                ->get()
                ->toArray();

            $activeUserCount = User::where(['role'=> USER_ROLE_CUSTOMER, 'status'=> USER_STATUS_ACTIVE])->count();

            $dayList = [];

            for ($day = 1; $day <= 7; $day++) {
                $dayName = Carbon::now()->subDays($day)->format('D');
                $dayList[$day] = $dayName;
            }

            $chartData = [];
            foreach ($dayList as $day) {
                $chartData[$day] = 0;
            }
            foreach ($dailyUser as $data) {
                $chartData[$data['day']] = $data['user'];
            }

            $data = [
                'chart_data' => $chartData,
                'active_user_count' => $activeUserCount,
                'ratio' => $rationOfUserActiveChart,
            ];


            return  $this->success($data, 'Data Found');
        }catch (\Exception $exception){
            return $this->error([], $exception->getMessage());
        }

    }

}

