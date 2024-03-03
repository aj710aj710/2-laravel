@extends('user.layouts.app')
@push('title')
    {{ __('Dashboard') }}
@endpush

@section('content')
    <div class="px-24 pb-24 position-relative">
        <!-- Info & Add product button -->
        <div class="d-flex justify-content-between align-items-center g-10 flex-wrap pb-20">
            <!-- Left -->
        </div>
        <!-- Block Summary -->
        <div class="row rg-24 pb-24">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="bg-white bd-one bd-c-stroke-color bd-ra-12 py-30 px-20">
                    <!-- Icon -->
                    <div class="mb-11 w-32 h-32 bd-ra-8 bg-purple-light d-flex justify-content-center align-items-center">
                        <img src="{{ asset('user/images/icon/user-fill.svg') }}" alt="" />
                    </div>
                    <!-- Title -->
                    <h4 class="fs-14 fw-400 lh-24 text-para-text pb-6">{{ __('Customers') }}</h4>
                    <!-- Month/Price -->
                    <p class="fs-24 fw-700 lh-24 text-textBlack">{{ $totalCustomer }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="bg-white bd-one bd-c-stroke-color bd-ra-12 py-30 px-20">
                    <!-- Icon -->
                    <div class="mb-11 w-32 h-32 bd-ra-8 bg-purple-light d-flex justify-content-center align-items-center">
                        <img src="{{ asset('user/images/icon/bell.svg') }}" alt="" />
                    </div>
                    <!-- Title -->
                    <h4 class="fs-14 fw-400 lh-24 text-para-text pb-6">{{ __('Subscriptions') }}</h4>
                    <!-- Month/Price -->
                    <p class="fs-24 fw-700 lh-24 text-textBlack">
                        {{ $totalSubscription }}/{{ showPrice($totalSubscriptionSales) }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="bg-white bd-one bd-c-stroke-color bd-ra-12 py-30 px-20">
                    <!-- Icon -->
                    <div class="mb-11 w-32 h-32 bd-ra-8 bg-purple-light d-flex justify-content-center align-items-center">
                        <img src="{{ asset('user/images/icon/dolor.svg') }}" alt="" />
                    </div>
                    <!-- Title -->
                    <h4 class="fs-14 fw-400 lh-24 text-para-text pb-6">{{ __('Monthly Recurring Revenue') }}</h4>
                    <!-- Month/Price -->
                    <p class="fs-24 fw-700 lh-24 text-textBlack">{{ showPrice($monthlyRecurringRevenue) }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="bg-white bd-one bd-c-stroke-color bd-ra-12 py-30 px-20">
                    <!-- Icon -->
                    <div class="mb-11 w-32 h-32 bd-ra-8 bg-purple-light d-flex justify-content-center align-items-center">
                        <img src="{{ asset('user/images/icon/total-sales.svg') }}" alt="" />
                    </div>
                    <!-- Title -->
                    <h4 class="fs-14 fw-400 lh-24 text-para-text pb-6">{{ __('Total Sales') }}</h4>
                    <!-- Month/Price -->
                    <p class="fs-24 fw-700 lh-24 text-textBlack">{{ showPrice($totalSales) }}</p>
                </div>
            </div>
        </div>
        <!-- Table Summary -->
        <div class="row rg-24">
            <div class="col-md-6">
                <div class="bg-white bd-one bd-c-stroke-color bd-ra-12 p-20">
                    <!--  -->
                    <div class="pb-20 d-flex justify-content-between align-items-center flex-wrap g-10">
                        <!--  -->
                        <div class="">
                            <p class="fs-14 fw-400 lh-20 text-para-text">{{ __('Total Subscription') }}</p>
                            <h4 class="fs-18 fw-600 lh-28 text-textBlack">{{$totalSubscription}}</h4>
                        </div>
                        <!--  -->
                        <div class="text-end">
                            <div class="d-flex justify-content-end align-items-center cg-8 pb-5">
                                <h4 class="fs-16 fw-700 lh-18 text-textBlack ratio-text">0%</h4>
                                <div
                                    class="w-21 h-21 rounded-circle ratio-icon-bg  d-flex justify-content-center align-items-center fs-12 text-white rotate-n-45">
                                    <i class="fa-solid ratio-icon"></i></div>
                            </div>
                            <p class="fs-14 fw-400 lh-20 text-para-text">{{ __('VS LAST WEEK') }}</p>
                        </div>
                    </div>
                    <!--  -->
                    <div class="">
                        <div id="activeUserChart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="bg-white bd-one bd-c-stroke-color bd-ra-12 p-20">
                    <!--  -->
                    <div class="pb-20 d-flex justify-content-between align-items-center flex-wrap g-10">
                        <!--  -->
                        <div class="">
                            <p class="fs-14 fw-400 lh-20 text-para-text">{{ __('Activity') }}</p>
                            <h4 class="fs-18 fw-600 lh-28 text-textBlack">{{ __('Product Sold Out') }}</h4>
                        </div>
                        <!-- Select -->
                        <div class="flex-grow-0 d-none">
                            <select class="sf-select-two cs-select-1" id="soldOutChart">
                                @foreach ($subscriptionyearList as $item)
                                    <option value="{{ $item['year'] }}">{{ $item['year'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!--  -->
                    <div class="">
                        <div id="activityChart"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="p-20 bd-one bd-c-stroke-color bd-ra-12 bg-white mb-24">
                    <h4 class="fs-18 fw-600 lh-24 text-textBlack pb-16">{{ __('Top Selling Plans') }}</h4>
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table zTable zTable-last-item-right">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <div class="min-w-120">{{ __('Plan Name') }}</div>
                                    </th>
                                    <th scope="col">
                                        <div>{{ __('Customers') }}</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($TopSellingPlans as $plan)
                                    <tr>
                                        <td>{{ $plan->plan_name }}</td>
                                        <td>{{ $plan->users_email }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center " colspan="2">{{ __('No Data Found') }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="p-20 bd-one bd-c-stroke-color bd-ra-12 bg-white">
                    <!--  -->
                    <div class="d-flex justify-content-between align-items-center flex-wrap g-10 pb-10">
                        <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{ __('Monthly Subscriber') }}</h4>
                        <!-- Select -->
                        <div class="flex-grow-0 d-flex align-items-center g-7">
                            <select class="sf-select-two cs-select-1" id="monthlySubscriber">
                                @foreach ($subscriptionyearList as $item)
                                    <option value="{{ $item['year'] }}">{{ $item['year'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table zTable zTable-last-item-right" id="monthlySubscriberTable">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <div>{{ __('Month') }}</div>
                                    </th>
                                    <th scope="col">
                                        <div>{{ __('Subscriber') }}</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($monthlySubscriber as $item)
                                    <tr>
                                        <td>{{ $item['month'] }}</td>
                                        <td>{{ $item['subscriber'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center " colspan="2">{{ __('No Data Found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="p-20 bd-one bd-c-stroke-color bd-ra-12 bg-white mb-24">
                    <h4 class="fs-18 fw-600 lh-24 text-textBlack pb-16">{{ __('Revenue Daily Stats') }}</h4>
                    <!-- Table -->
                    <table class="table zTable-1">
                        <tbody>
                            <tr>
                                <td>{{ __("Today's Sale") }}</td>
                                <td>{{ showPrice($totalSalesAmountToday) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __("Yesterday's Sale") }}</td>
                                <td>{{ showPrice($totalSalesAmountYesterday) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('Daily Average') }}</td>
                                <td>{{ showPrice($dailyAverage) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="p-20 bd-one bd-c-stroke-color bd-ra-12 bg-white">
                    <!--  -->
                    <div class="d-flex justify-content-between align-items-center flex-wrap g-10 pb-10">
                        <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{ __('Revenue Monthly State') }}</h4>
                        <!-- Select -->
                        <div class="flex-grow-0">
                            <select class="sf-select-two cs-select-1" id="monthlyRevenue">
                                @foreach ($subscriptionyearList as $item)
                                    <option value="{{ $item['year'] }}">{{ $item['year'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Table -->
                    <table class="table zTable zTable-last-item-right" id="monthlyRevenueTable">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <div>{{ __('Month') }}</div>
                                </th>
                                <th scope="col">
                                    <div>{{ __('Revenue') }}</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($monthlyRevenue as $item)
                                <tr>
                                    <td>{{ $item['month'] }}</td>
                                    <td>{{ showPrice($item['revenue']) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center " colspan="2">{{ __('No Data Found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <input type="hidden" id="monthly-subscriber-route" value="{{ route('user.monthly-subscriber') }}">
    <input type="hidden" id="monthly-revenue-route" value="{{ route('user.monthly-revenue') }}">
    <input type="hidden" id="product-sold-out-chart-data-route"
        value="{{ route('user.product-sold-out-chart-data') }}">
    <input type="hidden" id="daily-subscriber-chart-data-route"
        value="{{ route('user.daily-subscriber-chart-data') }}">
@endsection
@push('script')
    <script src="{{ asset('user/custom/js/dashboard.js') }}"></script>
@endpush
