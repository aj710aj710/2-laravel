@extends('affiliate.layouts.app')
@push('title')
    {{ __('Dashboard') }}
@endpush
@section('content')
    <div class="px-24 pb-24 position-relative">
        <div class="row rg-24 pb-24">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="bg-white bd-one bd-c-stroke-color bd-ra-12 py-30 px-20">
                    <!-- Icon -->
                    <div class="mb-11 w-32 h-32 bd-ra-8 bg-purple-light d-flex justify-content-center align-items-center">
                        <img src="{{ asset('user/images/icon/user-fill.svg') }}" alt="" />
                    </div>
                    <!-- Title -->
                    <h4 class="fs-14 fw-400 lh-24 text-para-text pb-6">{{ __('Total Commission') }}</h4>
                    <!-- Month/Price -->
                    <p class="fs-24 fw-700 lh-24 text-textBlack">{{ showPrice($totalCommission) }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="bg-white bd-one bd-c-stroke-color bd-ra-12 py-30 px-20">
                    <!-- Icon -->
                    <div class="mb-11 w-32 h-32 bd-ra-8 bg-purple-light d-flex justify-content-center align-items-center">
                        <img src="{{ asset('user/images/icon/bell.svg') }}" alt="" />
                    </div>
                    <!-- Title -->
                    <h4 class="fs-14 fw-400 lh-24 text-para-text pb-6">{{ __('Available Banance') }}</h4>
                    <!-- Month/Price -->
                    <p class="fs-24 fw-700 lh-24 text-textBlack">
                        {{ showPrice($availableBalance) }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="bg-white bd-one bd-c-stroke-color bd-ra-12 py-30 px-20">
                    <!-- Icon -->
                    <div class="mb-11 w-32 h-32 bd-ra-8 bg-purple-light d-flex justify-content-center align-items-center">
                        <img src="{{ asset('user/images/icon/dolor.svg') }}" alt="" />
                    </div>
                    <!-- Title -->
                    <h4 class="fs-14 fw-400 lh-24 text-para-text pb-6">{{ __('Total Affiliate') }}</h4>
                    <!-- Month/Price -->
                    <p class="fs-24 fw-700 lh-24 text-textBlack">{{ $totalAffiliate }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="bg-white bd-one bd-c-stroke-color bd-ra-12 py-30 px-20">
                    <!-- Icon -->
                    <div class="mb-11 w-32 h-32 bd-ra-8 bg-purple-light d-flex justify-content-center align-items-center">
                        <img src="{{ asset('user/images/icon/total-sales.svg') }}" alt="" />
                    </div>
                    <!-- Title -->
                    <h4 class="fs-14 fw-400 lh-24 text-para-text pb-6">{{ __('Total Link') }}</h4>
                    <!-- Month/Price -->
                    <p class="fs-24 fw-700 lh-24 text-textBlack">{{ $totalLink }}</p>
                </div>
            </div>
        </div>
        <div class="row rg-24 pb-24">
            <div class="col-md-12">
                <div class="bg-white bd-one bd-c-stroke-color bd-ra-12 p-20">
                    <!--  -->
                    <div class="pb-20 d-flex justify-content-between align-items-center flex-wrap g-10">
                        <!--  -->
                        <div class="">
                            <p class="fs-14 fw-400 lh-20 text-para-text">{{ __('Monthly') }}</p>
                            <h4 class="fs-18 fw-600 lh-28 text-textBlack">{{ __('Affiliate Monthly Commission History') }}
                            </h4>
                        </div>
                    </div>
                    <!--  -->
                    <div class="">
                        <div id="affiliateCommissionHistoryChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="product-sold-out-chart-data-route" value="{{ route('user.product-sold-out-chart-data') }}">
@endsection
@push('script')
    <script>
        const MONTHS = @json($affiliateHistoryMonthlyChartData['months']);
        const AFFILIATEMONLTHLYVALUE = @json($affiliateHistoryMonthlyChartData['monthlyValue']);
    </script>
    <script type="text/javascript" src="{{ asset('user/custom/js/affiliate-chart.js') }}"></script>
@endpush
