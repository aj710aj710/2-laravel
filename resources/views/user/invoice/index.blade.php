@extends('user.layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')
    <!-- Content -->
    <div class="px-24 pb-24 position-relative">
        <!-- Info & Add product button -->
        <div class="d-flex justify-content-between align-items-center g-10 flex-wrap pb-20">
            <!-- Left -->
            <div class="">
                <h4 class="fs-24 fw-500 lh-24 text-white"></h4>
            </div>
            <!-- Right -->
        </div>
        <!-- Select options -->
        <div class="py-26 px-20 bg-white bd-one bd-c-stroke-color bd-ra-8 mb-20">
            <div class="d-flex align-items-center cg-10">
                <div class="flex-grow-0">
                    <select class="sf-select-two" id="product-id">
                        <option value="all Products">{{ __('All Products') }}</option>
                        @foreach ($product as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-grow-0">
                    <select class="sf-select-two" id="plan-filter">
                        <option value="">{{ __('Select Plan') }}</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- Table -->
        <div class="p-20 bd-one bd-c-stroke-color bd-ra-12 bg-white overflow-hidden">
            <h4 class="fs-18 fw-600 lh-24 text-textBlack pb-13">{{ __('Invoice Details') }}</h4>
            <table class="table zTable zTable-last-item-right" id="invoiceDataTable">
                <thead>
                    <tr>
                        <th scope="col">
                            <div class="min-sm-w-100">{{ __('Invoice Id') }}</div>
                        </th>
                        <th scope="col">
                            <div class="min-sm-w-100">{{ __('Subscription Id') }}</div>
                        </th>
                        <th scope="col">
                            <div class="min-sm-w-100">{{ __('Customer') }}</div>
                        </th>
                        <th scope="col">
                            <div class="min-w-150">{{ __('Product Name') }}</div>
                        </th>
                        <th scope="col">
                            <div class="min-sm-w-100">{{ __('Plan Name') }}</div>
                        </th>
                        <th scope="col">
                            <div class="min-sm-w-100">{{ __('Amount') }}</div>
                        </th>
                        <th scope="col">
                            <div class="min-sm-w-100">{{ __('Time') }}</div>
                        </th>
                        <th scope="col">
                            <div class="min-sm-w-100">{{ __('Status') }}</div>
                        </th>
                        <th scope="col">
                            <div>{{ __('Action') }}</div>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <input type="hidden" id="invoice-list-route" value="{{ route('user.invoice.list') }}">
    <input type="hidden" id="plan-route" value="{{ route('user.invoice.get.plan.data') }}">
    <input type="hidden" id="invoice-view-route" value="{{ route('user.invoice.view') }}">
    <div class="modal fade" id="invoicePreviewModal" tabindex="-1" aria-labelledby="invoicePreviewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20 overflow-x-auto" id="invoice-data-view">
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('user/custom/js/invoice.js') }}"></script>
@endpush
