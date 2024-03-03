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
        <!-- Select options -->
        <div class="p-20 bd-one bd-c-stroke-color bd-ra-12 bg-white overflow-hidden">
            <div id="customersTable_wrapper" class="dataTables_wrapper no-footer">
                <table class="table zTable zTable-last-item-right dataTable no-footer dtr-inline" id="customersListDatatable"
                    aria-describedby="customersTable_info">
                    <thead>
                        <tr>
                            <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                <div class="min-sm-w-100">{{ __('Customer Name') }}</div>
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                <div class="min-sm-w-100">{{ __('Emails') }}</div>
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                <div class="min-sm-w-100">{{ __('Date') }}</div>
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                <div class="min-sm-w-100">{{ __('Country') }}</div>
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                <div class="min-sm-w-100">{{ __('Payments') }}</div>
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                <div class="min-sm-w-100">{{ __('Tax') }}</div>
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                <div class="min-sm-w-100">{{ __('Revenue') }}</div>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <input type="hidden" value="{{ route('user.report.customer.list') }}" id="report-customer-list-route">
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
