
<!-- Header -->
<div class="d-flex justify-content-between align-items-center cg-10 pb-16">
    <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{__("Update Tax")}}</h4>
    <button type="button"
            class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
            data-bs-dismiss="modal" aria-label="Close"><img src="{{asset('user/images/icon/close.svg')}}" alt=""/>
    </button>
</div>
<form class="ajax reset" action="{{ route('user.settings.tax.store') }}"
      method="POST" data-handler="commonResponse">
    @csrf
    <input type="hidden" value="{{$tax->id}}" name="id">
    <div class="col-12 pb-25">
        <div class="zForm-wrap">
            <label for="invoiceTotalProductAmount" class="zForm-label">{{__('Rule Title')}}</label>
            <input type="text" name="tax_rule_name" class="form-control zForm-control" value="{{$tax->tax_rule_name}}" placeholder="{{__('Tax Rule')}}" />
        </div>
    </div>
    <div class="col-12">
        <div class="zForm-wrap mb-5">
            <label class="zForm-label">{{ __('Select Product') }}</label>
            <select class="sf-select-without-search cs-select-form" id="product-id" name="product_id">
                <option>{{__('Select Product')}}</option>
                @foreach ($allProducts as $product)
                    <option {{ $tax->product_id == $product->id ? 'selected' : ''}} value="{{ $product->id }}">
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 mt-5 pt-3">
        <div class="zForm-wrap pb-20">
            <label class="zForm-label">{{ __('Select Plan') }}</label>
            <select class="sf-select-without-search cs-select-form plan-filter-data" name="plan_id">
                <option value="">{{__('Select Plan')}}</option>
                @foreach ($planList as $singlePlan)
                    <option {{$tax->plan_id == $singlePlan->id ? 'selected' : ''}} value="{{ $singlePlan->id }}">
                        {{ $singlePlan->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="zForm-wrap pb-20 mt-lg-5">
        <label for="eInputCouponDiscountType" class="zForm-label">{{__("Tax Type")}}</label>
        <div class="d-flex align-items-center flex-wrap g-10">
            <div
                class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                <input value="{{DISCOUNT_TYPE_FLAT}}" class="form-check-input" type="radio" id="couponDiscountTypeFlat"
                       name="tax_type" {{$tax->tax_type == DISCOUNT_TYPE_FLAT?'checked':''}} />
                <label class="form-check-label" for="couponDiscountTypeFlat">{{__("Flat")}}</label>
            </div>
            <div
                class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                <input value="{{DISCOUNT_TYPE_PERCENT}}" class="form-check-input" type="radio" id="couponDiscountTypePercent"
                       name="tax_type" {{$tax->tax_type == DISCOUNT_TYPE_PERCENT?'checked':''}} />
                <label class="form-check-label" for="couponDiscountTypePercent">{{__("Percent")}}</label>
            </div>
        </div>
    </div>
    <div class="col-12 mb-4">
        <div class="zForm-wrap">
            <label for="invoiceTotalProductAmount" class="zForm-label">{{__('Tax Amount')}}</label>
            <input type="text" name="tax_amount" value="{{$tax->tax_amount}}" step="0.01"  class="form-control zForm-control" placeholder="0.00 (%)" />
        </div>
    </div>
    <div class="zForm-wrap pb-20">
        <label for="eInputPlanPlanStatus" class="zForm-label">{{__("Status")}}</label>
        <div class="d-flex align-items-center flex-wrap g-10">
            <div
                class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                <input class="form-check-input" type="radio" value="1" id="planPlanStatusActive"
                       name="status" {{isset($tax->status) && $tax->status == 1?'checked':''}}/>
                <label class="form-check-label" for="planPlanStatusActive">{{__("Active")}}</label>
            </div>
            <div
                class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                <input class="form-check-input" type="radio" value="0" id="planPlanStatusInactive"
                       name="status" {{isset($tax->status) && $tax->status == 1?'':'checked'}}/>
                <label class="form-check-label" for="planPlanStatusInactive">{{__("Inactive")}}</label>
            </div>
        </div>
    </div>
    <button type="submit" class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">{{__('Update')}}</button>
</form>

@push('script')
    <script src="{{ asset('user/custom/js/tax.js') }}"></script>
@endpush
