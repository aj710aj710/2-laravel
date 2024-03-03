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
        <!-- Table -->
        <div class="p-20 bd-one bd-c-stroke-color bd-ra-12 bg-white overflow-hidden">
            <h4 class="fs-18 fw-600 lh-24 text-textBlack pb-13">{{ __('Customer Details') }}</h4>
            <div id="customersTable_wrapper" class="dataTables_wrapper no-footer">
                <table class="table zTable zTable-last-item-right dataTable no-footer dtr-inline" id="customersTable"
                    aria-describedby="customersTable_info">
                    <thead>
                        <tr>
                            <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                <div class="min-w-150">{{ __('Customer Name') }}</div>
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                <div class="min-sm-w-100">{{ __('Emails') }}</div>
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                <div class="min-w-120">{{ __('Created Date') }}</div>
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                <div class="min-sm-w-100">{{ __('Country') }}</div>
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                <div class="min-sm-w-100">{{ __('Payments') }}</div>
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                <div class="min-sm-w-100">{{ __('Revenue') }}</div>
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                <div class="min-sm-w-100">{{ __('Action') }}</div>
                            </th>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <!-- Page content area end -->
    @endsection
    @push('script')
        <script src="{{ asset('user/custom/js/customer.js') }}"></script>
    @endpush
