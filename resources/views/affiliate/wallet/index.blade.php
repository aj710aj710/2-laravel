@extends('affiliate.layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')
    <!-- Page content area start -->
    <div class="px-24 pb-24 position-relative">
        <!-- Table -->
        <div class="p-20 bd-one bd-c-stroke-color bd-ra-12 bg-white overflow-hidden">
            <div class="align-items-center d-flex flex-wrap gap-2 justify-content-between mb-18">
                <div class="">
                    <h4>{{__('My Balance')}} {{ showPrice(auth()->user()->affiliate_commission_amount) }}</h4>
                </div>
                <div class="d-flex gap-2 justify-content-end">
                    <button class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#withdrawModal">{{ __('Request a Withdrawal') }}</button>
                    <button class="border-0 bd-ra-12 bg-main-color py-13 px-25 fs-16 fw-600 lh-19 text-white"
                            data-bs-toggle="modal"
                            data-bs-target="#beneficiaryModal">{{ __('Add Beneficiary') }}</button>
                </div>
            </div>
            <ul class="nav nav-tabs zTab-reset zTab-one" id="myTab" role="tablist">
                <li class="nav-item order-action" role="presentation">
                    <button class="nav-link active order-action" data-bs-toggle="tab"
                            data-bs-target="#transaction-tab-pane"
                            type="button" role="tab" data-order="transaction" aria-controls="transaction-tab-pane"
                            aria-selected="true"
                            tabindex="-1">{{ __('Transaction history') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link order-action" data-bs-toggle="tab" data-order="withdrawal"
                            data-bs-target="#withdrawal-tab-pane" type="button" role="tab"
                            aria-controls="withdrawal-tab-pane"
                            aria-selected="false" tabindex="-1">{{ __('Withdrawal history') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link order-action" data-bs-toggle="tab" data-bs-target="#beneficiary-tab-pane"
                            type="button" role="tab" aria-controls="beneficiary-tab-pane" data-order="beneficiary"
                            aria-selected="false"
                            tabindex="-1">{{ __('Beneficiary List') }}
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="transaction-tab-pane" role="tabpanel"
                     aria-labelledby="transaction-tab"
                     tabindex="0">
                    <div id="orderTable_wrapper" class="dataTables_wrapper no-footer">
                        <table class="table zTable zTable-last-item-right dataTable no-footer dtr-inline"
                               id="transactionHistoryDataTable" aria-describedby="transactionTable">
                            <thead>
                            <tr>
                                <th>
                                    <div class="min-w-150">{{ __('#SL') }}</div>
                                </th>
                                <th>
                                    <div class="min-w-150">{{ __('Date') }}</div>
                                </th>
                                <th>
                                    <div class="min-w-150">{{ __('Type') }}</div>
                                </th>
                                <th>
                                    <div class="min-w-150">{{ __('Purpose') }}</div>
                                </th>
                                <th>
                                    <div class="min-w-150">{{ __('Amount') }}</div>
                                </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="withdrawal-tab-pane" role="tabpanel" aria-labelledby="withdrawal-tab"
                     tabindex="0">
                    <div id="orderTable_wrapper" class="dataTables_wrapper no-footer">
                        <table class="table zTable zTable-last-item-right dataTable no-footer dtr-inline"
                               id="withdrawDataTable" aria-describedby="withdrawalTable">
                            <thead>
                                <tr>
                                    <th>
                                        <div>{{ __('#SL') }}</div>
                                    </th>
                                    <th>
                                        <div>{{ __('Date') }}</div>
                                    </th>
                                    <th>
                                        <div>{{ __('Payment Details') }}</div>
                                    </th>
                                    <th>
                                        <div>{{ __('Amount') }}</div>
                                    </th>
                                    <th>
                                        <div>{{ __('Status') }}</div>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="beneficiary-tab-pane" role="tabpanel" aria-labelledby="beneficiary-tab"
                     tabindex="0">
                    <div id="orderTable_wrapper" class="dataTables_wrapper no-footer">
                        <table class="table zTable zTable-last-item-right dataTable no-footer dtr-inline"
                               id="beneficiaryTable" aria-describedby="beneficiaryTable">
                            <thead>
                            <tr>
                                <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                    <div class="min-w-150">{{ __('Name') }}</div>
                                </th>
                                <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                    <div class="min-sm-w-100">{{ __('Type') }}</div>
                                </th>
                                <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                    <div class="min-w-150">{{ __('Data') }}</div>
                                </th>
                                <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                    <div class="min-w-150">{{ __('Status') }}</div>
                                </th>
                                <th scope="col" class="sorting_disabled" rowspan="1" colspan="1">
                                    <div class="min-sm-w-100">{{ __('Action') }}</div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($beneficiaries as $beneficiary)
                                <tr>
                                    <td>{{$beneficiary->beneficiary_name}}</td>
                                    <td>{{getBeneficiaryName($beneficiary->type)}}</td>
                                    <td>{!! getBeneficiaryDetails($beneficiary) !!}</td>
                                    <td>
                                        @if ($beneficiary->status == STATUS_ACTIVE)
                                            <p class='zBadge zBadge-active'>{{__('Active')}}</p>
                                        @else
                                            <p class='zBadge zBadge-fuilure'>{{__('Inactive')}}</p>
                                        @endif
                                    </td>
                                    <td>
                                        <ul class="d-flex align-items-center cg-5 justify-content-center">
                                            <li class="d-flex gap-2">
                                                <button
                                                    onclick=getEditModal("{{route('affiliate.beneficiary.edit', $beneficiary->id)}}",'#edit-modal')
                                                    class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white">
                                                    <img src="{{asset('assets/images/icon/edit.svg')}}"
                                                         alt="{{__('Edit')}}"/>
                                                </button>
                                                <button
                                                    onclick=deleteItem("{{route('affiliate.beneficiary.delete', $beneficiary->id)}}")
                                                    class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white">
                                                    <img src="{{asset('assets/images/icon/delete-1.svg')}}"
                                                         alt="{{__('Delete')}}">
                                                </button>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- order payment edit modal -->
        <div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">
                    <div class="d-flex justify-content-between align-items-center cg-10 pb-24">
                        <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{__('Withdraw Request')}}</h4>
                        <button type="button"
                                class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
                                data-bs-dismiss="modal" aria-label="Close">
                            <img src="{{asset('user/images/icon/close.svg')}}" alt="">
                        </button>
                    </div>
                    <form class="ajax reset" action="{{route('affiliate.withdraw.request')}}"
                          method="POST" enctype="multipart/form-data" data-handler="commonResponseWithPageLoad">
                        @csrf
                        <div class="rg-20 row">
                            <div class="col-12">
                                <div class="zForm-wrap">
                                    <label for="withdrawAmount" class="zForm-label">{{__('Amount')}} <span
                                            class="text-red">*</span></label>
                                    <input type="number" min="1" class="form-control zForm-control" id="withdrawAmount"
                                           placeholder="Enter Amount" name="amount">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="zForm-wrap">
                                    <label class="zForm-label">{{ __('Beneficiary') }} <span
                                            class="text-red">*</span></label>
                                    <select class="sf-select-without-search cs-select-form" id="beneficiary_id"
                                            name="beneficiary_id">
                                        @foreach($beneficiaries->where('status',STATUS_ACTIVE) as $beneficiary)
                                            <option
                                                value="{{$beneficiary->id}}">{{$beneficiary->beneficiary_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center cg-10">
                                    <button type="submit"
                                            class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">
                                        {{__('Request Now')}}
                                    </button>
                                    <button type="button"
                                            class="border-0 bd-ra-12 py-13 px-25 bg-cancel-color fs-16 fw-600 lh-19 text-textBlack"
                                            data-bs-dismiss="modal">{{__('Cancel Now')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- order show modal -->
        <div class="modal fade" id="beneficiaryModal" tabindex="-1" aria-labelledby="beneficiaryModal"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">
                    <div class="d-flex justify-content-between align-items-center cg-10 pb-24">
                        <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{__('Beneficiary Form')}}</h4>
                        <button type="button"
                                class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
                                data-bs-dismiss="modal" aria-label="Close">
                            <img src="{{asset('user/images/icon/close.svg')}}" alt="">
                        </button>
                    </div>
                    <form class="ajax reset" action="{{route('affiliate.beneficiary.store')}}"
                          method="POST" enctype="multipart/form-data" data-handler="commonResponseWithPageLoad">
                        @csrf
                        <div class="rg-20 row">
                            <div class="col-12">
                                <div class="zForm-wrap">
                                    <label for="beneficiary_name" class="zForm-label">{{__('Beneficiary Name')}} <span
                                            class="text-red">*</span></label>
                                    <input type="text" min="1" class="form-control zForm-control"
                                           placeholder="{{__('Beneficiary Name')}}" name="beneficiary_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="zForm-wrap">
                                    <label class="zForm-label">{{ __('Type') }} <span
                                            class="text-red">*</span></label>
                                    <select class="sf-select-without-search cs-select-form" name="type">
                                        <option selected
                                                value="{{ BENEFICIARY_CARD }}">{{ getBeneficiaryName(BENEFICIARY_CARD) }}
                                        </option>
                                        <option
                                            value="{{ BENEFICIARY_BANK }}">{{ getBeneficiaryName(BENEFICIARY_BANK) }}
                                        </option>
                                        <option
                                            value="{{ BENEFICIARY_PAYPAL }}">{{ getBeneficiaryName(BENEFICIARY_PAYPAL) }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="zForm-wrap">
                                    <label class="zForm-label">{{ __('Status') }} <span
                                            class="text-red">*</span></label>
                                    <select class="sf-select-without-search cs-select-form" name="status">
                                        <option selected value="{{ STATUS_ACTIVE }}">{{ __('Active') }}
                                        </option>
                                        <option value="{{ STATUS_DISABLE }}">{{ __('Disable') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="input-block-{{BENEFICIARY_CARD}}" class="input-block rg-20 row mt-18">
                            <div class="col-12">
                                <div class="zForm-wrap">
                                    <label for="card_number" class="zForm-label">{{__('Card number')}} <span
                                            class="text-red">*</span></label>
                                    <input type="text" class="form-control zForm-control"
                                           placeholder="{{__('1245 2154 2154 215')}}" name="card_number">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="zForm-wrap">
                                    <label for="card_holder_name" class="zForm-label">{{__('Card Holder Name')}} <span
                                            class="text-red">*</span></label>
                                    <input type="text" class="form-control zForm-control"
                                           placeholder="{{__('1245 2154 2154 215')}}" name="card_holder_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="zForm-wrap">
                                    <label class="zForm-label">{{ __('Month') }} <span
                                            class="text-red">*</span></label>
                                    <select class="sf-select-without-search cs-select-form" name="expire_month">
                                        <option value="1" selected>{{
                                            __('January') }}</option>
                                        <option value="2">{{
                                            __('February') }}</option>
                                        <option value="3">{{
                                            __('March') }}</option>
                                        <option value="4">{{
                                            __('April') }}</option>
                                        <option value="5">{{
                                            __('May') }}</option>
                                        <option value="6">{{
                                            __('June') }}</option>
                                        <option value="7">{{
                                            __('July') }}</option>
                                        <option value="8">{{
                                            __('August') }}</option>
                                        <option value="9">{{
                                            __('September') }}</option>
                                        <option value="10">{{
                                            __('October') }}</option>
                                        <option value="11">{{
                                            __('November') }}</option>
                                        <option value="12">{{
                                            __('December') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="zForm-wrap">
                                    <label class="zForm-label">{{ __('Year') }} <span
                                            class="text-red">*</span></label>
                                    <select class="sf-select-without-search cs-select-form" name="expire_year">
                                        @for($year = date('Y'); $year < \Carbon\Carbon::now()->addYear(20)->format('Y'); $year++)
                                            <option
                                                {{date('Y') == $year ? 'selected' : ''}} value="{{$year}}">{{$year}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="input-block-{{BENEFICIARY_PAYPAL}}" class="input-block d-none rg-20 row mt-18">
                            <div class="col-12">
                                <div class="zForm-wrap">
                                    <label for="paypal_email" class="zForm-label">{{__('Paypal Email')}} <span
                                            class="text-red">*</span></label>
                                    <input type="text" class="form-control zForm-control"
                                           placeholder="{{__('EX. example@email.com')}}" name="paypal_email">
                                </div>
                            </div>
                        </div>
                        <div id="input-block-{{BENEFICIARY_BANK}}" class="input-block d-none rg-20 row mt-18">
                            <div class="col-12">
                                <div class="zForm-wrap">
                                    <label for="bank_name" class="zForm-label">{{__('Bank Name')}} <span
                                            class="text-red">*</span></label>
                                    <input type="text" class="form-control zForm-control"
                                           placeholder="{{__('EX. Switch Bank')}}" name="bank_name">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="zForm-wrap">
                                    <label for="account_name" class="zForm-label">{{__('Account Name')}} <span
                                            class="text-red">*</span></label>
                                    <input type="text" class="form-control zForm-control"
                                           placeholder="{{__('Mr. XYZ')}}" name="account_name">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="zForm-wrap">
                                    <label for="bank_account_number" class="zForm-label">{{__('Bank Account Number')}}
                                        <span
                                            class="text-red">*</span></label>
                                    <input type="text" class="form-control zForm-control"
                                           placeholder="{{__('0000000000')}}" name="bank_account_number">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="zForm-wrap">
                                    <label for="bank_routing_number" class="zForm-label">{{__('Bank Routing Number')}}
                                        <span
                                            class="text-red">*</span></label>
                                    <input type="text" class="form-control zForm-control"
                                           placeholder="{{__('Ex. 546484')}}" name="bank_routing_number">
                                </div>
                            </div>
                        </div>
                        <div class="rg-20 row mt-18">
                            <div class="col-12">
                                <div class="d-flex align-items-center cg-10">
                                    <button type="submit"
                                            class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">
                                        {{__('Add')}}
                                    </button>
                                    <button type="button"
                                            class="border-0 bd-ra-12 py-13 px-25 bg-cancel-color fs-16 fw-600 lh-19 text-textBlack"
                                            data-bs-dismiss="modal">{{__('Cancel')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="edit-modal"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">

                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="beneficiaryList" value="{{ route('user.orders.payment.status') }}">
    <input type="hidden" id="withdrawList" value="{{ route('user.orders.payment.status') }}">
    <input type="hidden" id="TransactionList" value="{{ route('user.orders.payment.status') }}">
    <input type="hidden" id="affiliateWalletRoute" value="{{ route('affiliate.wallet') }}">
    <input type="hidden" id="affiliateWithdrawRoute" value="{{ route('affiliate.withdraw.index') }}">
    <!-- Page content area end -->
@endsection
@push('script')
    <script src="{{ asset('user/custom/js/wallet.js') }}"></script>
@endpush
