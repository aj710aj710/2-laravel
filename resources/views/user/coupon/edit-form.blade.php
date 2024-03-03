<!-- Header -->
<!-- Header -->
<div class="d-flex justify-content-between align-items-center cg-10 pb-16">
    <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{__("Update Coupon")}}</h4>
    <button type="button"
            class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
            data-bs-dismiss="modal" aria-label="Close"><img src="{{asset('user')}}/images/icon/close.svg" alt=""/>
    </button>
</div>
<!-- Body -->
<form class="ajax" action="{{ route('user.coupon.store') }}"
      method="POST" enctype="multipart/form-data" data-handler="settingCommonHandler">
    @csrf
    <div class="zForm-wrap pb-20">
        <input type="hidden" name="id" value="{{encrypt($coupon->id)}}">
        <label for="eInputCouponName" class="zForm-label">{{__('Coupon Name')}}<span
                class="text-red">*</span></label>
        <input type="text" class="form-control zForm-control" id="eInputCouponName"
               placeholder="{{__("Enter Coupon name")}}" name="coupon_name" value="{{$coupon->name}}"/>
    </div>
    <div class="zForm-wrap pb-20">
        <label for="eInputCouponCode" class="zForm-label">{{__("Coupon Code")}}<span
                class="text-red">*</span></label>
        <input type="text" class="form-control zForm-control" id="eInputCouponCode"
               placeholder="{{__("Enter Coupon Code")}}" name="coupon_code" value="{{$coupon->code}}"/>
    </div>
    <div class="zForm-wrap pb-20">
        <label for="eInputCouponDiscountType" class="zForm-label">{{__("Discount Type")}}<span
                class="text-red">*</span></label>
        <div class="d-flex align-items-center flex-wrap g-10">
            <div
                class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                <input class="form-check-input" type="radio" value="{{DISCOUNT_TYPE_FLAT}}" id="couponDiscountTypeFlat"
                       name="discount_type"  {{$coupon->discount_type == DISCOUNT_TYPE_FLAT?'checked':''}} />
                <label class="form-check-label" for="couponDiscountTypeFlat">{{__("Flat")}}</label>
            </div>
            <div
                class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                <input class="form-check-input" type="radio" value="{{DISCOUNT_TYPE_PERCENT}}" id="couponDiscountTypePercent"
                       name="discount_type" {{$coupon->discount_type == DISCOUNT_TYPE_PERCENT?'checked':''}}/>
                <label class="form-check-label" for="couponDiscountTypePercent">{{__("Percent")}}</label>
            </div>
        </div>
    </div>
    <div class="zForm-wrap pb-25">
        <label for="eInputDiscount" class="zForm-label">{{__("Discount")}}<span class="text-red">*</span></label>
        <input type="number" class="form-control zForm-control" id="eInputDiscount" placeholder="0" name="discount" value="{{$coupon->discount}}"/>
    </div>
    <div class="zForm-wrap pb-20">
        <label for="eInputCouponRedemptionType" class="zForm-label">{{__("Redemption Type")}}<span
                class="text-red">*</span></label>
        <div class="d-flex align-items-center flex-wrap g-10">
            <div
                class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color ">
                <input class="form-check-input redemption-type" type="radio" value="{{REDEMPTION_TYPE_ONETIME}}" id="couponRedemptionTypeOneTime"
                       name="redemption_type" {{$coupon->redemption_type == REDEMPTION_TYPE_ONETIME?'checked':''}}/>
                <label class="form-check-label" for="couponRedemptionTypeOneTime">{{__("One Time")}}</label>
            </div>
            <div
                class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                <input class="form-check-input redemption-type" type="radio" value="{{REDEMPTION_TYPE_FOREVER}}" id="couponRedemptionTypeForever"
                       name="redemption_type" {{$coupon->redemption_type == REDEMPTION_TYPE_FOREVER?'checked':''}}/>
                <label class="form-check-label" for="couponRedemptionTypeForever">{{__("Forever")}}</label>
            </div>
            <div
                class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                <input class="form-check-input redemption-type" type="radio" value="{{REDEMPTION_TYPE_LIMITED_NUMBER}}"
                       id="couponRedemptionLimitedNumbers" name="redemption_type" {{$coupon->redemption_type == REDEMPTION_TYPE_LIMITED_NUMBER?'checked':''}}/>
                <label class="form-check-label" for="couponRedemptionLimitedNumbers">{{__("Limited Numbers")}}
                </label>
            </div>
        </div>
    </div>
    <div class="d-flex cg-10 pb-20">
        <div class="zForm-wrap flex-grow-1 min-w-224">
            <label for="eInputCouponAssociatePlans" class="zForm-label">{{__("Associate Plans")}}<span
                    class="text-red">*</span></label>
            <select class="sf-select-without-search cs-select-form product-plan" name="product_plan">
                <option>{{__("Select Plan")}}</option>
                @if(count($planList) > 0)
                    @foreach($planList as $plan)
                        <option value="{{$plan->id}}" {{$coupon->product_plan == $plan->id?'selected':'' }}>{{$plan->name}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="zForm-wrap flex-grow-1">
            <label for="eInputCouponValidUpto" class="zForm-label">{{__("Valid Upto")}}<span
                    class="text-red">*</span></label>
            <input type="text" class="form-control zForm-control date-time-picker date-icon"
                   id="eInputCouponValidUpto" placeholder="{{__("Select Date")}}" name="valid_date" value="{{$coupon->valid_date}}"/>
        </div>
    </div>

    <div class="zForm-wrap pb-20 maximum-redemption d-none">
        <label for="eInputMaximumRedemption" class="zForm-label">{{__("Maximum Redemption")}}<span
                class="text-red">*</span></label>
        <input type="text" class="form-control zForm-control" id="eInputMaximumRedemption"
               placeholder="" name="maximum_redemption" value="{{$coupon->maximum_redemption}}"/>
    </div>
    <!-- Buttons -->
    <div class="d-flex align-items-center cg-10">
        <button type="submit" class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">{{__("Update
             Now")}}
        </button>
        <button type="button" class="border-0 bd-ra-12 py-13 px-25 bg-cancel-color fs-16 fw-600 lh-19 text-textBlack">
            {{__("Cancel Now")}}
        </button>
    </div>
</form>
@push('script')

@endpush
