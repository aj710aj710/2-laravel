<div class="d-flex justify-content-between align-items-center cg-10 pb-24">
    <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{__('Beneficiary Update')}}</h4>
    <button type="button"
            class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
            data-bs-dismiss="modal" aria-label="Close">
        <img src="{{asset('user/images/icon/close.svg')}}" alt="">
    </button>
</div>
<form class="ajax reset" action="{{route('affiliate.beneficiary.update', $beneficiary->id)}}"
      method="POST" enctype="multipart/form-data" data-handler="commonResponseWithPageLoad">
    @csrf
    <div class="rg-20 row">
        <div class="col-12">
            <div class="zForm-wrap">
                <label for="beneficiary_name" class="zForm-label">{{__('Beneficiary Name')}} <span
                        class="text-red">*</span></label>
                <input type="text" min="1" class="form-control zForm-control"
                       placeholder="{{__('Beneficiary Name')}}" value="{{$beneficiary->beneficiary_name}}" name="beneficiary_name">
            </div>
        </div>
        <div class="col-md-6">
            <div class="zForm-wrap">
                <label class="zForm-label">{{ __('Type') }} <span
                        class="text-red">*</span></label>
                <select class="sf-select-without-search cs-select-form" name="type">
                    <option {{$beneficiary->type == BENEFICIARY_CARD ? 'selected' : ''}} value="{{ BENEFICIARY_CARD }}">{{ getBeneficiaryName(BENEFICIARY_CARD) }}
                    </option>
                    <option {{$beneficiary->type == BENEFICIARY_BANK ? 'selected' : ''}} value="{{ BENEFICIARY_BANK }}">{{ getBeneficiaryName(BENEFICIARY_BANK) }}
                    </option>
                    <option {{$beneficiary->type == BENEFICIARY_PAYPAL ? 'selected' : ''}} value="{{ BENEFICIARY_PAYPAL }}">{{ getBeneficiaryName(BENEFICIARY_PAYPAL) }}
                    </option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="zForm-wrap">
                <label class="zForm-label">{{ __('Status') }} <span
                        class="text-red">*</span></label>
                <select class="sf-select-without-search cs-select-form" name="status">
                    <option {{$beneficiary->status == STATUS_ACTIVE ? 'selected' : ''}} value="{{ STATUS_ACTIVE }}">{{ __('Active') }}
                    </option>
                    <option {{$beneficiary->status == STATUS_DISABLE ? 'selected' : ''}} value="{{ STATUS_DISABLE }}">{{ __('Disable') }}
                    </option>
                </select>
            </div>
        </div>
    </div>
    <div id="input-block-{{BENEFICIARY_CARD}}" class="{{$beneficiary->type != BENEFICIARY_CARD ? 'd-none' : ''}} input-block rg-20 row mt-18">
        <div class="col-12">
            <div class="zForm-wrap">
                <label for="card_number" class="zForm-label">{{__('Card number')}} <span
                        class="text-red">*</span></label>
                <input value="{{$beneficiary->card_number}}" type="text" class="form-control zForm-control"
                       placeholder="{{__('1245 2154 2154 215')}}" name="card_number">
            </div>
        </div>
        <div class="col-12">
            <div class="zForm-wrap">
                <label for="card_holder_name" class="zForm-label">{{__('Card Holder Name')}} <span
                        class="text-red">*</span></label>
                <input type="text" value="{{$beneficiary->card_holder_name}}" class="form-control zForm-control"
                       placeholder="{{__('1245 2154 2154 215')}}" name="card_holder_name">
            </div>
        </div>
        <div class="col-md-6">
            <div class="zForm-wrap">
                <label class="zForm-label">{{ __('Month') }} <span
                        class="text-red">*</span></label>
                <select class="sf-select-without-search cs-select-form" name="expire_month">
                    <option {{$beneficiary->expire_month == 1 && $beneficiary->type != BENEFICIARY_CARD ? 'selected' : ''}} value="1">{{
                                            __('January') }}</option>
                    <option {{$beneficiary->expire_month == 2 ? 'selected' : ''}} value="2">{{
                                            __('February') }}</option>
                    <option {{$beneficiary->expire_month == 3 ? 'selected' : ''}} value="3">{{
                                            __('March') }}</option>
                    <option {{$beneficiary->expire_month == 4 ? 'selected' : ''}} value="4">{{
                                            __('April') }}</option>
                    <option {{$beneficiary->expire_month == 5 ? 'selected' : ''}} value="5">{{
                                            __('May') }}</option>
                    <option {{$beneficiary->expire_month == 6 ? 'selected' : ''}} value="6">{{
                                            __('June') }}</option>
                    <option {{$beneficiary->expire_month == 7 ? 'selected' : ''}} value="7">{{
                                            __('July') }}</option>
                    <option {{$beneficiary->expire_month == 8 ? 'selected' : ''}} value="8">{{
                                            __('August') }}</option>
                    <option {{$beneficiary->expire_month == 9 ? 'selected' : ''}} value="9">{{
                                            __('September') }}</option>
                    <option {{$beneficiary->expire_month == 10 ? 'selected' : ''}} value="10">{{
                                            __('October') }}</option>
                    <option {{$beneficiary->expire_month == 11 ? 'selected' : ''}} value="11">{{
                                            __('November') }}</option>
                    <option {{$beneficiary->expire_month == 12 ? 'selected' : ''}} value="12">{{
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
                            {{date('Y') == $year && $beneficiary->type != BENEFICIARY_BANK ? 'selected' : ($year == $beneficiary->expire_year ? 'selected' : '')}} value="{{$year}}">{{$year}}</option>
                    @endfor
                </select>
            </div>
        </div>
    </div>
    <div id="input-block-{{BENEFICIARY_PAYPAL}}" class="input-block {{$beneficiary->type != BENEFICIARY_PAYPAL ? 'd-none' : ''}} rg-20 row mt-18">
        <div class="col-12">
            <div class="zForm-wrap">
                <label for="paypal_email" class="zForm-label">{{__('Paypal Email')}} <span
                        class="text-red">*</span></label>
                <input value="{{$beneficiary->paypal_email}}" type="text" class="form-control zForm-control"
                       placeholder="{{__('EX. example@email.com')}}" name="paypal_email">
            </div>
        </div>
    </div>
    <div id="input-block-{{BENEFICIARY_BANK}}" class="input-block {{$beneficiary->type != BENEFICIARY_BANK ? 'd-none' : ''}} rg-20 row mt-18">
        <div class="col-12">
            <div class="zForm-wrap">
                <label for="bank_name" class="zForm-label">{{__('Bank Name')}} <span
                        class="text-red">*</span></label>
                <input value="{{$beneficiary->bank_name}}" type="text" class="form-control zForm-control"
                       placeholder="{{__('EX. Switch Bank')}}" name="bank_name">
            </div>
        </div>
        <div class="col-12">
            <div class="zForm-wrap">
                <label for="account_name" class="zForm-label">{{__('Account Name')}} <span
                        class="text-red">*</span></label>
                <input value="{{$beneficiary->account_name}}" type="text" class="form-control zForm-control"
                       placeholder="{{__('Mr. XYZ')}}" name="account_name">
            </div>
        </div>
        <div class="col-12">
            <div class="zForm-wrap">
                <label for="bank_account_number" class="zForm-label">{{__('Bank Account Number')}}
                    <span
                        class="text-red">*</span></label>
                <input type="text" value="{{$beneficiary->bank_account_number}}" class="form-control zForm-control"
                       placeholder="{{__('0000000000')}}" name="bank_account_number">
            </div>
        </div>
        <div class="col-12">
            <div class="zForm-wrap">
                <label for="bank_routing_number" class="zForm-label">{{__('Bank Routing Number')}}
                    <span
                        class="text-red">*</span></label>
                <input type="text" value="{{$beneficiary->bank_routing_number}}" class="form-control zForm-control"
                       placeholder="{{__('Ex. 546484')}}" name="bank_routing_number">
            </div>
        </div>
    </div>
    <div class="rg-20 row mt-18">
        <div class="col-12">
            <div class="d-flex align-items-center cg-10">
                <button type="submit"
                        class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">
                    {{__('Update')}}
                </button>
                <button type="button"
                        class="border-0 bd-ra-12 py-13 px-25 bg-cancel-color fs-16 fw-600 lh-19 text-textBlack"
                        data-bs-dismiss="modal">{{__('Cancel')}}
                </button>
            </div>
        </div>
    </div>
</form>
