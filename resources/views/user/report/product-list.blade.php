@extends('user.layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')
    <div class="px-24 pb-24 position-relative">
        <div class="d-flex justify-content-between align-items-center g-10 flex-wrap pb-20">
            <div class="">
                <h4 class="fs-24 fw-500 lh-24 text-white"></h4>
            </div>
        </div>
        <div class="p-20 bd-one bd-c-stroke-color bd-ra-12 bg-white overflow-hidden">
            <table class="table zTable zTable-last-item-right" id="productListDataTable">
                <thead>
                    <tr>
                        <th scope="col">
                            <div class="min-w-150">{{ __('Product Name') }}</div>
                        </th>
                        <th scope="col">
                            <div class="min-w-150">{{ __('Total Plans') }}</div>
                        </th>
                        <th scope="col">
                            <div class="min-w-150">{{ __('Total Coupons') }}</div>
                        </th>
                        <th scope="col">
                            <div class="min-w-150">{{ __('Total Addons') }}</div>
                        </th>
                        <th scope="col">
                            <div class="min-w-150">{{ __('Date') }}</div>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <input type="hidden" value="{{ route('user.report.product.list') }}" id="report-products-list-route">
@endsection
@push('script')
    <script src="{{ asset('assets/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('user/custom/js/report.js') }}"></script>
@endpush
