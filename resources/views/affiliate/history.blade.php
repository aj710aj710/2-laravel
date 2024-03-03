@extends('affiliate.layouts.app')
@push('title')
    {{ __('Dashboard') }}
@endpush
@section('content')
@section('content')
    <div class="px-24 pb-24 position-relative">
        <div class="d-flex justify-content-between align-items-center g-10 flex-wrap pb-20">
            <div class="">
                {{-- <h4 class="fs-24 fw-500 lh-24 text-white">{{ __($pageTitle) }}</h4> --}}
            </div>
        </div>
        <div class="p-20 bd-one bd-c-stroke-color bd-ra-12 bg-white">
            <h4 class="fs-18 fw-600 lh-24 text-textBlack pb-13">{{ __('Affiliate History') }}</h4>
            <table class="table zTable zTable-last-item-right" id="affiliateHistoryDataTable">
                <thead>
                    <tr>
                        <th scope="col">
                            <div class="min-sm-w-150">{{ __('#SL') }}</div>
                        </th>
                        <th scope="col">
                            <div class="min-sm-w-150">{{ __('Product') }}</div>
                        </th>
                        <th scope="col">
                            <div class="min-sm-w-100">{{ __('Plan') }}</div>
                        </th>
                        <th scope="col">
                            <div class="min-sm-w-100">{{ __('Date') }}</div>
                        </th>
                        <th scope="col">
                            <div class="min-sm-w-100">{{ __('Plan Price') }}</div>
                        </th>
                        <th scope="col">
                            <div class="min-sm-w-100">{{ __('Commission') }}</div>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <input type="hidden" id="affiliateHistoryRoute" value="{{ route('affiliate.history') }}">
@endsection
@push('script')
    <script src="{{ asset('user/custom/js/affiliate-dashboard.js') }}"></script>
@endpush
