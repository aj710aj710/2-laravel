@extends('user.layouts.app')
@push('title')
    {{ __($title) }}
@endpush
@push('style')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush
@section('content')
    <input type="hidden" id="product-list-route" value="{{route('user.product.list')}}">
    <input type="hidden" id="plan-list-route" value="{{route('user.plan.list-for-dropdown')}}">
    <div class="px-24 pb-24 position-relative">
        <!-- Info & Add product button -->
        <div class="d-flex justify-content-between align-items-center g-10 flex-wrap pb-20">
            <!-- Left -->
            <div class="">
                <h4 class="fs-24 fw-500 lh-24 text-white">{{__($title)}}</h4>
            </div>
            <!-- Right -->
            <button class="border-0 bd-ra-12 bg-main-color py-13 px-25 fs-16 fw-600 lh-19 text-white"
                    data-bs-toggle="modal" data-bs-target="#addProductModal">+ {{__('Add Product')}}
            </button>
        </div>
        <!-- Table -->
        <div class="p-20 bd-one bd-c-stroke-color bd-ra-12 bg-white">
            <h4 class="fs-18 fw-600 lh-24 text-textBlack pb-13">{{__("Products")}}</h4>
            <table class="table zTable zTable-last-item-right" id="productTable">
                <thead>
                <tr>
                    <th scope="col">
                        <div class="min-sm-w-150">{{__("Name")}}</div>
                    </th>
                    <th scope="col">
                        <div class="min-sm-w-100">{{__("Plans")}}</div>
                    </th>
                    <th scope="col">
                        <div class="min-sm-w-100">{{__("Coupons")}}</div>
                    </th>
                    <th scope="col">
                        <div class="min-sm-w-100">{{__("License")}}</div>
                    </th>
                    <th scope="col">
                        <div>{{__("Action")}}</div>
                    </th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- Add product modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center cg-10 pb-24">
                    <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{__("Add Product")}}</h4>
                    <button type="button"
                            class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
                            data-bs-dismiss="modal" aria-label="Close"><img
                            src="{{asset('user')}}/images/icon/close.svg" alt=""/></button>
                </div>
                <!-- Body -->
                <form class="ajax reset" action="{{ route('user.product.store') }}"
                      method="POST" enctype="multipart/form-data" data-handler="settingCommonHandler">
                    @csrf
                    <div class="zForm-wrap pb-20">
                        <label for="eInputProductName" class="zForm-label">{{__("Product Name")}} <span class="text-red">*</span></label>
                        <input type="text" class="form-control zForm-control" id="eInputProductName"
                               placeholder="{{__("Enter product name")}}" name="name"/>
                    </div>
                    <div class="zForm-wrap pb-20">
                        <label for="eInputProductDescription" class="zForm-label">{{__("Product Description")}}</label>
                        <textarea class="form-control zForm-control h-111" id="eInputProductDescription"
                                  placeholder="{{__("Write your thoughts here....")}}" name="description"></textarea>
                    </div>
                    <div class="d-flex align-items-center cg-10">
                        <button type="submit"
                                class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">{{__("Submit Now")}}</button>
                        <button type="button"
                            class="border-0 bd-ra-12 py-13 px-25 bg-cancel-color fs-16 fw-600 lh-19 text-textBlack" data-bs-dismiss="modal">{{__("Cancel Now")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- edit product modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">
            </div>
        </div>
    </div>

    <!-- Add Plan modal -->
    <div class="modal fade" id="addPlanModal" tabindex="-1" aria-labelledby="addPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center cg-10 pb-16">
                    <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{__("Add Plan")}}</h4>
                    <button type="button"
                            class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
                            data-bs-dismiss="modal" aria-label="Close"><img src="{{asset('user')}}/images/icon/close.svg" alt=""/>
                    </button>
                </div>
                <!-- Body -->
                <input type="hidden" id="product-list-route" value="{{route('user.plan.list')}}">
                <form class="ajax reset-form" action="{{ route('user.plan.store') }}"
                      method="POST" enctype="multipart/form-data" data-handler="settingCommonHandler" id="addPlanId">
                    @csrf

                    <input type="hidden" name="product_id" value="" id="productId">
                    <div class="zForm-wrap pb-20">
                        <label for="eInputPlanName" class="zForm-label">{{__("Plan Name")}}<span class="text-red">*</span></label>
                        <input type="text" class="form-control zForm-control" id="eInputPlanName"
                               placeholder="{{__("Enter Plan name")}}" name="name"/>
                    </div>
                    <div class="zForm-wrap pb-20">
                        <label for="eInputPlanCode" class="zForm-label">{{__("Plan Code")}}<span class="text-red">*</span></label>
                        <input type="text" class="form-control zForm-control" id="eInputPlanCode"
                               placeholder="{{__("Enter Plan Code")}}" name="code"/>
                    </div>
                    <div class="zForm-wrap pb-25">
                        <label for="eInputPlanPrice" class="zForm-label">{{__("Plan Price")}}<span
                                class="text-red">*</span></label>
                        <input type="number" class="form-control zForm-control" id="eInputPlanPrice"
                               placeholder="88.00" name="price"/>
                    </div>
                    <div class="zForm-wrap pb-25">
                        <label for="eInputPlanPrice" class="zForm-label">{{__("Due Day")}}<span
                                class="text-red">*</span></label>
                        <input type="text" class="form-control zForm-control" id="eInputPlanDay"
                               placeholder="5 day" name="due_day"/>
                    </div>
                    <div class="zForm-wrap pb-25">
                        <label for="eInputPlanPrice" class="zForm-label">{{__("Shipping Charge")}}</label>
                        <input type="text" class="form-control zForm-control" id="eInputPlanDay"
                               placeholder="0.00" name="shipping_charge"/>
                    </div>
                    <div class="zForm-wrap pb-20 bilingCycle-checkbox">
                        <label for="eInputPlanBillingCycle" class="zForm-label">{{__("Billing Cycle")}}<span class="text-red">*</span></label>
                        <div class="d-flex align-items-center flex-wrap g-10">
                            <div class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color bilingCycle-checkbox-item">
                                <input class="form-check-input" type="radio" value="{{BILLING_CYCLE_ONETIME}}" id="planBillingCycleOneTime" name="billing_cycle" checked />
                                <label class="form-check-label" for="planBillingCycleOneTime">{{__("One Time")}}</label>
                            </div>
                            <div class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color bilingCycle-checkbox-item">
                                <input class="form-check-input" type="radio" value="{{BILLING_CYCLE_AUTO_RENEW}}" id="planBillingCycleAutoRenew" name="billing_cycle" />
                                <label class="form-check-label" for="planBillingCycleAutoRenew">{{__("Auto renews until cancelled")}}</label>
                            </div>
                            <div class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color bilingCycle-checkbox-item">
                                <input class="form-check-input" type="radio" value="{{BILLING_CYCLE_EXPIRE_AFTER}}" id="planBillingCycleExpire" name="billing_cycle" />
                                <label class="form-check-label" for="planBillingCycleExpire">{{__("Expire after a specified no. of billing cycle")}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="bilingCycle-open-items">
                        <div class="bilingCycle-open-item billing-cycle-item d-none">
                            <div class="zForm-wrap pb-20 billing-cycle-item-recurring-number d-none">
                                <label for="eInputNumberOfRecurringCycle" class="zForm-label">{{__("Number Of Recurring Cycle")}}</label>
                                <input type="text" class="form-control zForm-control" id="eInputNumberOfRecurringCycle" placeholder="5" name="number_of_recurring_cycle"/>
                            </div>
                            <div class="d-flex cg-10 pb-20">
                                <div class="zForm-wrap flex-grow-1">
                                    <label for="eInputBill2" class="zForm-label">{{__("Bill Every")}}</label>
                                    <input type="text" class="form-control zForm-control" id="eInputBill2" placeholder="1" name="bill"/>
                                </div>
                                <div class="zForm-wrap flex-grow-1 min-w-224">
                                    <label for="eInputEvery2" class="zForm-label text-white">.</label>
                                    <select class="sf-select-two cs-select-form" name="duration">
                                        <option value="{{DURATION_MONTH}}">{{__("Month")}}</option>
                                        <option value="{{DURATION_YEAR}}">{{__("Year")}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="zForm-wrap pb-20">
                        <label for="eInputPlanPlanStatus" class="zForm-label">{{__("Plan Status")}}<span class="text-red">*</span></label>
                        <div class="d-flex align-items-center flex-wrap g-10">
                            <div
                                class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                                <input class="form-check-input" type="radio" value="1" id="planPlanStatusActive"
                                       name="status" checked/>
                                <label class="form-check-label" for="planPlanStatusActive">{{__("Active")}}</label>
                            </div>
                            <div
                                class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                                <input class="form-check-input" type="radio" value="0" id="planPlanStatusInactive"
                                       name="status"/>
                                <label class="form-check-label" for="planPlanStatusInactive">{{__("Inactive")}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex cg-10 pb-20">
                        <div class="zForm-wrap flex-grow-1">
                            <label for="eInputFreeTrail" class="zForm-label">{{__("Free Trail")}}</label>
                            <input type="text" class="form-control zForm-control" id="eInputFreeTrail"
                                   placeholder="10" name="free_trail"/>
                        </div>
                        <div class="zForm-wrap flex-grow-1">
                            <label for="eInputSetupFee" class="zForm-label">{{__("Setup Fee")}}</label>
                            <input type="text" class="form-control zForm-control" id="eInputSetupFee"
                                   placeholder="10" name="setup_fee"/>
                        </div>
                    </div>
                    <div class="zForm-wrap pb-20">
                            <label for="eInputFreeTrail" class="zForm-label">{{__("Details")}}</label>
                            <textarea class="form-control zForm-control" id="summernote" cols="30"
                                   placeholder="10" name="details"></textarea>
                    </div>
                    <!-- Buttons -->
                    <div class="d-flex align-items-center cg-10">
                        <button type="submit" class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">{{__("Save Now")}}
                        </button>
                        <button type="button" class="border-0 bd-ra-12 py-13 px-25 bg-cancel-color fs-16 fw-600 lh-19 text-textBlack" data-bs-dismiss="modal">
                            {{__("Cancel Now")}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Coupon modal -->
    <div class="modal fade" id="addCouponModal" tabindex="-1" aria-labelledby="addCouponModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center cg-10 pb-16">
                    <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{__("Add Coupon")}}</h4>
                    <button type="button"
                            class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
                            data-bs-dismiss="modal" aria-label="Close"><img src="{{asset('user')}}/images/icon/close.svg" alt=""/>
                    </button>
                </div>
                <!-- Body -->
                <form class="ajax reset-form" action="{{ route('user.coupon.store') }}"
                      method="POST" enctype="multipart/form-data" data-handler="settingCommonHandler">
                    @csrf
                    <div class="zForm-wrap pb-20">
                        <input type="hidden" name="product_id" id="productId2">
                        <label for="eInputCouponName" class="zForm-label">{{__('Coupon Name')}}<span
                                class="text-red">*</span></label>
                        <input type="text" class="form-control zForm-control" id="eInputCouponName"
                               placeholder="Enter Coupon name" name="coupon_name"/>
                    </div>
                    <div class="zForm-wrap pb-20">
                        <label for="eInputCouponCode" class="zForm-label">{{__("Coupon Code")}}<span
                                class="text-red">*</span></label>
                        <input type="text" class="form-control zForm-control" id="eInputCouponCode"
                               placeholder="Enter Coupon Code" name="coupon_code"/>
                    </div>
                    <div class="zForm-wrap pb-20">
                        <label for="eInputCouponDiscountType" class="zForm-label">{{__("Discount Type")}}<span
                                class="text-red">*</span></label>
                        <div class="d-flex align-items-center flex-wrap g-10">
                            <div
                                class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                                <input class="form-check-input" type="radio" value="{{DISCOUNT_TYPE_FLAT}}" id="couponDiscountTypeFlat"
                                       name="discount_type"  checked/>
                                <label class="form-check-label" for="couponDiscountTypeFlat">{{__("Flat")}}</label>
                            </div>
                            <div
                                class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                                <input class="form-check-input" type="radio" value="{{DISCOUNT_TYPE_PERCENT}}" id="couponDiscountTypePercent"
                                       name="discount_type"/>
                                <label class="form-check-label" for="couponDiscountTypePercent">{{__("Percent")}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="zForm-wrap pb-25">
                        <label for="eInputDiscount" class="zForm-label">{{__("Discount")}}<span class="text-red">*</span></label>
                        <input type="number" class="form-control zForm-control" id="eInputDiscount" placeholder="0" name="discount"/>
                    </div>
                    <div class="zForm-wrap pb-20">
                        <label for="eInputCouponRedemptionType" class="zForm-label">{{__("Redemption Type")}}<span
                                class="text-red">*</span></label>
                        <div class="d-flex align-items-center flex-wrap g-10">
                            <div
                                class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color ">
                                <input class="form-check-input redemption-type" type="radio" value="{{REDEMPTION_TYPE_ONETIME}}" id="couponRedemptionTypeOneTime"
                                       name="redemption_type" checked/>
                                <label class="form-check-label" for="couponRedemptionTypeOneTime">{{__("One Time")}}</label>
                            </div>
                            <div
                                class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                                <input class="form-check-input redemption-type" type="radio" value="{{REDEMPTION_TYPE_FOREVER}}" id="couponRedemptionTypeForever"
                                       name="redemption_type"/>
                                <label class="form-check-label" for="couponRedemptionTypeForever">{{__("Forever")}}</label>
                            </div>
                            <div
                                class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                                <input class="form-check-input redemption-type" type="radio" value="{{REDEMPTION_TYPE_LIMITED_NUMBER}}"
                                       id="couponRedemptionLimitedNumbers" name="redemption_type"/>
                                <label class="form-check-label" for="couponRedemptionLimitedNumbers">{{__("Limited Numbers")}}
                                    </label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex cg-10 pb-20">
                        <div class="zForm-wrap flex-grow-1 min-w-224">
                            <label for="eInputCouponAssociatePlans" class="zForm-label">{{__("Associate Plans")}}<span
                                    class="text-red">*</span></label>
                            <select class="sf-select-two cs-select-form product-plan" name="product_plan">
                                <option>{{__("Select Plan")}}</option>
                            </select>
                        </div>
                        <div class="zForm-wrap flex-grow-1">
                            <label for="eInputCouponValidUpto" class="zForm-label">{{__("Valid Upto")}}<span
                                    class="text-red">*</span></label>
                            <input type="text" class="form-control zForm-control date-time-picker date-icon"
                                   id="eInputCouponValidUpto" placeholder="{{__("Select Date")}}" name="valid_date"/>
                        </div>
                    </div>

                        <div class="zForm-wrap pb-20 maximum-redemption d-none">
                        <label for="eInputMaximumRedemption" class="zForm-label">{{__("Maximum Redemption")}}<span
                                class="text-red">*</span></label>
                        <input type="text" class="form-control zForm-control" id="eInputMaximumRedemption"
                               placeholder="{{__("All plans")}}" name="maximum_redemption"/>
                    </div>
                    <!-- Buttons -->
                    <div class="d-flex align-items-center cg-10">
                        <button type="submit" class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">{{__("Save
                            Now")}}
                        </button>
                        <button type="button" class="border-0 bd-ra-12 py-13 px-25 bg-cancel-color fs-16 fw-600 lh-19 text-textBlack " data-bs-dismiss="modal">
                            {{__("Cancel Now")}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add License modal -->
    <div class="modal fade" id="addLicenseModal" tabindex="-1" aria-labelledby="addLicenseModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center cg-10 pb-16">
                    <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{__("Add License")}}</h4>
                    <button type="button"
                            class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
                            data-bs-dismiss="modal" aria-label="Close"><img src="{{asset('user')}}/images/icon/close.svg" alt=""/>
                    </button>
                </div>
                <!-- Body -->
                <form class="ajax reset-form" action="{{ route('user.license.store') }}" method="POST" enctype="multipart/form-data" data-handler="settingCommonHandler">
                    @csrf
                    <div class="zForm-wrap pb-20">
                        <input type="hidden" name="product_id" id="productId3">
                        <label for="eInputLicenseName" class="zForm-label">{{__("License Name")}}<span
                                class="text-red">*</span></label>
                        <input type="text" class="form-control zForm-control" id="eInputLicenseName"
                               placeholder="{{__("Enter License name")}}" name="name"/>
                    </div>
                    <div class="zForm-wrap pb-20">
                        <label for="eInputLicenseCouponCode" class="zForm-label">{{"License Code"}}<span
                                class="text-red">*</span></label>
                        <input type="text" class="form-control zForm-control" id="eInputLicenseCouponCode"
                               placeholder="{{__("Enter License Code")}}" name="code"/>
                    </div>

                    <div class="zForm-wrap pb-20">
                        <label for="licenseStatus" class="zForm-label">{{__("License Status")}}<span
                                class="text-red">*</span></label>
                        <div class="d-flex align-items-center flex-wrap g-10">
                            <div
                                class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                                <input class="form-check-input" type="radio" value="1" id="licenseStatusActive"
                                       name="status" checked/>
                                <label class="form-check-label" for="licenseStatusActive">{{__("Active")}}</label>
                            </div>
                            <div
                                class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                                <input class="form-check-input" type="radio" value="0" id="licenseStatusInactive"
                                       name="status"/>
                                <label class="form-check-label" for="licenseStatusInactive">{{__("Inactive")}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="zForm-wrap pb-20">
                        <label for="eInputLicenseSelectPlan" class="zForm-label">{{__("Select Plan")}}<span
                                class="text-red">*</span></label>
                        <select class="sf-select-two cs-select-form product-plan" name="product_plan">
                            <option value="all Plan">{{__("All Plan")}}</option>
                        </select>
                    </div>
                    <!-- Buttons -->
                    <div class="d-flex align-items-center cg-10">
                        <button type="submit" class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">{{__("Save
                            Now")}}
                        </button>
                        <button type="button" class="border-0 bd-ra-12 py-13 px-25 bg-cancel-color fs-16 fw-600 lh-19 text-textBlack" data-bs-dismiss="modal">
                            {{__("Cancel Now")}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('user/custom/js/product.js') }}"></script>
    <script src="{{ asset('user/custom/js/common.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 200
            });
        });
    </script>
@endpush
