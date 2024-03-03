@extends('user.layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')
    <!-- Page content area start -->
    <div class="px-24 pb-24 position-relative">
        <!-- Info & Add product button -->
        <div class="d-flex justify-content-between align-items-center g-10 flex-wrap pb-20">
            <div class="">
                <h4 class="fs-24 fw-500 lh-24 text-white"></h4>
            </div>
        </div>
        <div class="row rg-24 pb-24">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="bg-white bd-one bd-c-stroke-color bd-ra-12 py-30 px-20">
                    <!-- Icon -->
                    <div class="mb-11 w-32 h-32 bd-ra-8 bg-purple-light d-flex justify-content-center align-items-center">
                        <img src="{{ asset('user/images/icon/user-fill.svg') }}" alt="">
                    </div>
                    <!-- Title -->
                    <h4 class="fs-14 fw-400 lh-24 text-para-text pb-6">{{ __('Customers') }}</h4>
                    <!-- Month/Price -->
                    <p class="fs-24 fw-700 lh-24 text-textBlack">{{ $customerAll }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="bg-white bd-one bd-c-stroke-color bd-ra-12 py-30 px-20">
                    <!-- Icon -->
                    <div class="mb-11 w-32 h-32 bd-ra-8 bg-purple-light d-flex justify-content-center align-items-center">
                        <img src="{{ asset('user/images/icon/flash.svg') }}" alt="">
                    </div>
                    <!-- Title -->
                    <h4 class="fs-14 fw-400 lh-24 text-para-text pb-6">{{ __('Products') }}</h4>
                    <!-- Month/Price -->
                    <p class="fs-24 fw-700 lh-24 text-textBlack">{{ $productAll }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="bg-white bd-one bd-c-stroke-color bd-ra-12 py-30 px-20">
                    <!-- Icon -->
                    <div class="mb-11 w-32 h-32 bd-ra-8 bg-purple-light d-flex justify-content-center align-items-center">
                        <img src="{{ asset('user/images/icon/bell.svg') }}" alt="">
                    </div>
                    <!-- Title -->
                    <h4 class="fs-14 fw-400 lh-24 text-para-text pb-6">{{ __('Subscriptions') }}</h4>
                    <!-- Month/Price -->
                    <p class="fs-24 fw-700 lh-24 text-textBlack">{{ $subscriptionAll }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="bg-white bd-one bd-c-stroke-color bd-ra-12 py-30 px-20">
                    <!-- Icon -->
                    <div class="mb-11 w-32 h-32 bd-ra-8 bg-purple-light d-flex justify-content-center align-items-center">
                        <img src="{{ asset('user/images/icon/sales.svg') }}" alt="">
                    </div>
                    <!-- Title -->
                    <h4 class="fs-14 fw-400 lh-24 text-para-text pb-6">{{ __('Sales') }}</h4>
                    <!-- Month/Price -->
                    <p class="fs-24 fw-700 lh-24 text-textBlack">{{ showPrice($orderAmount) }}</p>
                </div>
            </div>
        </div>


        <!-- Table -->
        <div class="p-20 bd-one bd-c-stroke-color bd-ra-12 bg-white overflow-hidden">
            <div id="customersTable_wrapper" class="dataTables_wrapper no-footer">
                <table class="table zTable zTable-last-item-right dataTable no-footer dtr-inline" id="orderDataTable"
                    aria-describedby="orderDataTable">
                    <thead>
                        <tr>
                            <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                <div class="min-sm-w-100">{{ __('Invoice') }}</div>
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                <div class="min-sm-w-100">{{ __('Subscription') }}</div>
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                <div class="min-sm-w-100">{{ __('Gateway') }}</div>
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                <div class="min-sm-w-100">{{ __('Amount') }}</div>
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                <div class="min-sm-w-100">{{ __('Customer') }}</div>
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                <div class="min-sm-w-100">{{ __('Product Name') }}</div>
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                <div class="min-sm-w-100">{{ __('Plan Name') }}</div>
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                <div class="min-sm-w-100">{{ __('Created Date') }}</div>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <input type="hidden" value="{{ route('user.orders.sales') }}" id="order-list-route">
        <!-- Page content area end -->
    @endsection
    @push('script')
        <script src="{{ asset('user/custom/js/sales.js') }}"></script>
    @endpush
