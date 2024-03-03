@extends('user.layouts.app')
@push('title')
    {{$pageTitle}}
@endpush
@section('content')
    <!-- Content -->
    <div class="px-24 pb-24 position-relative">
        <!-- Info & Add product button -->
        <div class="d-flex justify-content-between align-items-center g-10 flex-wrap pb-20">
            <div class="">
                <h4 class="fs-24 fw-500 lh-24 text-white"></h4>
            </div>
        </div>
        <div class="py-26 px-20 bg-white bd-one bd-c-stroke-color bd-ra-8 mb-20">
            <div class="d-flex align-items-center cg-10">
                <div class="flex-grow-0">
                    <select class="sf-select-two" id="product-id">
                        <option value="">{{__('All Products')}}</option>
                        @foreach($product as $data)
                            <option value="{{$data->id}}">{{$data->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-grow-0">
                    <select class="sf-select-two" id="plan-filter">
                        <option value="">{{__('Select Plan')}}</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- Table -->
        <div class="p-20 bd-one bd-c-stroke-color bd-ra-12 bg-white overflow-hidden">
            <h4 class="fs-18 fw-600 lh-24 text-textBlack pb-13">{{__('Subscription')}}</h4>
            <table class="table zTable zTable-last-item-right" id="subscriptionDataTable">
                <thead>
                <tr>
                    <th scope="col">
                        <div class="min-sm-w-100">{{__('Customer')}}</div>
                    </th>
                    <th scope="col">
                        <div class="min-sm-w-100">{{__('Product Name')}}</div>
                    </th>
                    <th scope="col">
                        <div class="min-sm-w-100">{{__('Plan Name')}}</div>
                    </th>
                    <th scope="col">
                        <div class="min-sm-w-100">{{__('Date')}}</div>
                    </th>
                    <th scope="col">
                        <div class="min-sm-w-100">{{__('Expiry Date')}}</div>
                    </th>
                    <th scope="col">
                        <div class="min-sm-w-100">{{__('Status')}}</div>
                    </th>
                    <th scope="col">
                        <div>{{__('Price')}}</div>
                    </th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <input type="hidden" id="subscription-list-route" value="{{ route('user.subscription.list') }}">
    <input type="hidden" id="plan-route" value="{{ route('user.subscription.get.plan.data') }}">
@endsection

@push('script')
    <script src="{{ asset('user/custom/js/subscription.js') }}"></script>
@endpush
