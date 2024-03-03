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
            <ul class="nav nav-tabs zTab-reset zTab-one" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active order-action" data-bs-toggle="tab" data-bs-target="#all-tab-pane"
                        type="button" data-order="all" role="tab" aria-controls="all-tab-pane"
                        aria-selected="true">{{ __('All') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link order-action" data-bs-toggle="tab" data-bs-target="#paid-tab-pane"
                        type="button" role="tab" data-order="paid" aria-controls="paid-tab-pane" aria-selected="false"
                        tabindex="-1">{{ __('Paid') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link order-action" data-bs-toggle="tab" data-order="pending"
                        data-bs-target="#pending-tab-pane" type="button" role="tab" aria-controls="pending-tab-pane"
                        aria-selected="false" tabindex="-1">{{ __('Pending') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link order-action" data-bs-toggle="tab" data-bs-target="#bank-tab-pane"
                        type="button" role="tab" aria-controls="bank-tab-pane" data-order="bank" aria-selected="false"
                        tabindex="-1">{{ __('Bank Pending') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link order-action" data-bs-toggle="tab" data-bs-target="#cancel-tab-pane"
                        type="button" role="tab" aria-controls="cancel-tab-pane" data-order="cancelled"
                        aria-selected="false" tabindex="-1">{{ __('Cancel') }}
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel" aria-labelledby="all-tab"
                    tabindex="0">
                    <div id="orderTable_wrapper" class="dataTables_wrapper no-footer">
                        <table class="table zTable zTable-last-item-right dataTable no-footer dtr-inline"
                            id="orderDataTableall" aria-describedby="allOrderDataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-w-150">{{ __('Customer Name') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Email') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-w-150">{{ __('Product Name') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-w-120">{{ __('Plan Name') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Gateway') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Amount') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-w-150">{{ __('Created Date') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Status') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Action') }}</div>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="paid-tab-pane" role="tabpanel" aria-labelledby="paid-tab"
                    tabindex="0">
                    <div id="orderTable_wrapper" class="dataTables_wrapper no-footer">
                        <table class="table zTable zTable-last-item-right dataTable no-footer dtr-inline"
                            id="orderDataTablepaid" aria-describedby="allOrderDataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-w-150">{{ __('Customer Name') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Email') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-w-150">{{ __('Product Name') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-w-120">{{ __('Plan Name') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Gateway') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Amount') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-w-150">{{ __('Created Date') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Status') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Action') }}</div>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="pending-tab-pane" role="tabpanel" aria-labelledby="pending-tab"
                    tabindex="0">
                    <div id="orderTable_wrapper" class="dataTables_wrapper no-footer">
                        <table class="table zTable zTable-last-item-right dataTable no-footer dtr-inline"
                            id="orderDataTablepending" aria-describedby="allOrderDataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-w-150">{{ __('Customer Name') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Email') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-w-150">{{ __('Product Name') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-w-120">{{ __('Plan Name') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Gateway') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Amount') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-w-150">{{ __('Created Date') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Status') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Action') }}</div>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="cancel-tab-pane" role="tabpanel"
                    aria-labelledby="cancel-tab"tabindex="0">
                    <div id="orderTable_wrapper" class="dataTables_wrapper no-footer">
                        <table class="table zTable zTable-last-item-right dataTable no-footer dtr-inline"
                            id="orderDataTablecancelled" aria-describedby="allOrderDataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-w-150">{{ __('Customer Name') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Email') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-w-150">{{ __('Product Name') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-w-120">{{ __('Plan Name') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Gateway') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Amount') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-w-150">{{ __('Created Date') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Status') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Action') }}</div>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="bank-tab-pane" role="tabpanel" aria-labelledby="bank-tab"tabindex="0">
                    <div id="orderTable_wrapper" class="dataTables_wrapper no-footer">
                        <table class="table zTable zTable-last-item-right dataTable no-footer dtr-inline"
                            id="orderDataTablebank" aria-describedby="allOrderDataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-w-150">{{ __('Customer Name') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Email') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-w-150">{{ __('Product Name') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-w-120">{{ __('Plan Name') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Gateway') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Amount') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-w-150">{{ __('Created Date') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Status') }}</div>
                                    </th>
                                    <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                        <div class="min-sm-w-100">{{ __('Action') }}</div>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <!-- order payment edit modal -->
        <div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="editPaymentModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">

                </div>
            </div>
        </div>

        <!-- order show modal -->
        <div class="modal fade" id="showPaymentModal" tabindex="-1" aria-labelledby="showPaymentModal"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">

                </div>
            </div>
        </div>




        <input type="hidden" id="ordersAllRoute" value="{{ route('user.orders.payment.status') }}">
        <input type="hidden" value="{{ route('user.orders.sales') }}" id="all-tab">
        <!-- Page content area end -->
    @endsection
    @push('script')
        <script src="{{ asset('user/custom/js/order.js') }}"></script>
    @endpush
