@extends('frontend.layouts.app')
@push('title')
    {{ __(@$pageTitle) }}
@endpush
@section('content')
    <div class="zMain-checkout">
        <div class="zMain-checkout-wrap">
            <div class="container">
                <div class="zMain-checkout-content">
                    <h4 class="title">{{ __($checkoutPage?->title) }}</h4>
                    <form class="ajax" action="{{ route('checkout.order') }}" method="POST"
                          data-handler="checkoutOrderResponse">
                        @csrf
                        <input type="hidden" id="selectGateway" name="gateway">
                        <input type="hidden" id="selectCurrency" name="currency">
                        <input type="hidden" value="{{ request()->route()->parameters('hash')['hash'] }}"
                               name="checkout_details">
                        <div class="payment-form">
                            <img src="{{ getFileUrl($checkoutPage->image) }}" alt="">
                        </div>
                        <div class="payment-form-wrap">
                            <!-- Left -->
                            <div class="left">
                                <!-- Basic Info -->
                                <div class="pb-30">
                                    <h4 class="fs-16 fw-600 lh-24 text-textBlack pb-15">{{ __('Basic Info') }}</h4>
                                    <div class="row rg-20" id="basicInfo">

                                        <div class="col-lg-6">
                                            <div class="zForm-wrap">
                                                <label class="zForm-label">{{ __('First Name') }}</label>
                                                <input type="text" name="basic_first_name"
                                                       class="form-control zForm-control"
                                                       placeholder="{{ __('First Name') }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="zForm-wrap">
                                                <label class="zForm-label">{{ __('Last Name') }}</label>
                                                <input type="text" name="basic_last_name"
                                                       class="form-control zForm-control"
                                                       placeholder="{{ __('Last Name') }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="zForm-wrap">
                                                <label class="zForm-label">{{ __('Email') }}</label>
                                                <input type="email" name="basic_email"
                                                       class="form-control zForm-control"
                                                       placeholder="{{ __('Email') }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="zForm-wrap">
                                                <label class="zForm-label">{{ __('Phone') }}</label>
                                                <input type="text" name="basic_phone" class="form-control zForm-control"
                                                       placeholder="{{ __('Phone') }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="zForm-wrap">
                                                <label class="zForm-label">{{ __('Company') }}</label>
                                                <input type="text" name="basic_company"
                                                       class="form-control zForm-control"
                                                       placeholder="{{ __('Company') }}"/>
                                            </div>
                                        </div>
                                        @if (json_decode($checkoutPage?->basic_info))
                                            @foreach (json_decode($checkoutPage?->basic_info) ?? [] as $basicInfo)
                                                @if ($basicInfo->type == 'text' || $basicInfo->type == 'number' || $basicInfo->type == 'email')
                                                    <div class="col-lg-6">
                                                        <div class="zForm-wrap">
                                                            <label
                                                                class="zForm-label">{{ __($basicInfo->label) }}</label>
                                                            <input type="{{ $basicInfo->type }}"
                                                                   name="basic_info[{{ $basicInfo->name }}]"
                                                                   class="form-control zForm-control"
                                                                   placeholder="{{ __($basicInfo->label) }}"/>
                                                        </div>
                                                    </div>
                                                @elseif ($basicInfo->type == 'textarea')
                                                    <div class="col-lg-6">
                                                        <div class="zForm-wrap">
                                                            <label
                                                                class="zForm-label">{{ __($basicInfo->label) }}</label>
                                                            <textarea name="basic_info[{{ $basicInfo->name }}]"
                                                                      class="form-control zForm-control"
                                                                      placeholder="{{ __($basicInfo->label) }}"></textarea>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <!-- Billing Info -->
                                <div class="pb-30">
                                    <h4 class="fs-16 fw-600 lh-24 text-textBlack pb-15">{{ __('Billing Info') }}</h4>
                                    <div class="row rg-20" id="billingInfo">
                                        <div class="col-lg-6">
                                            <div class="zForm-wrap">
                                                <label class="zForm-label">{{ __('Address') }}</label>
                                                <input type="text" name="billing_address"
                                                       class="form-control zForm-control"
                                                       placeholder="{{ __('Address') }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="zForm-wrap">
                                                <label class="zForm-label">{{ __('Zip Code') }}</label>
                                                <input type="text" name="billing_zip_code"
                                                       class="form-control zForm-control"
                                                       placeholder="{{ __('Zip Code') }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="zForm-wrap">
                                                <label class="zForm-label">{{ __('City') }}</label>
                                                <input type="text" name="billing_city"
                                                       class="form-control zForm-control"
                                                       placeholder="{{ __('City') }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="zForm-wrap">
                                                <label class="zForm-label">{{ __('State') }}</label>
                                                <input type="text" name="billing_state"
                                                       class="form-control zForm-control"
                                                       placeholder="{{ __('State') }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="zForm-wrap">
                                                <label class="zForm-label">{{ __('Country') }}</label>
                                                <input type="text" name="billing_country"
                                                       class="form-control zForm-control"
                                                       placeholder="{{ __('Country') }}"/>
                                            </div>
                                        </div>
                                        @if (json_decode($checkoutPage?->billing_info))
                                            @foreach (json_decode($checkoutPage?->billing_info) ?? [] as $billingInfo)
                                                @if ($billingInfo->type == 'text' || $billingInfo->type == 'number' || $billingInfo->type == 'email')
                                                    <div class="col-lg-6">
                                                        <div class="zForm-wrap">
                                                            <label
                                                                class="zForm-label">{{ __($billingInfo->label) }}</label>
                                                            <input type="{{ $billingInfo->type }}"
                                                                   name="billing_info[{{ $billingInfo->name }}]"
                                                                   class="form-control zForm-control"
                                                                   placeholder="{{ __($billingInfo->label) }}"/>
                                                        </div>
                                                    </div>
                                                @elseif ($billingInfo->type == 'textarea')
                                                    <div class="col-lg-6">
                                                        <div class="zForm-wrap">
                                                            <label
                                                                class="zForm-label">{{ __($billingInfo->label) }}</label>
                                                            <textarea name="billing_info[{{ $billingInfo->name }}]"
                                                                      type="{{ $billingInfo->type }}"
                                                                      class="form-control zForm-control"
                                                                      placeholder="{{ __($billingInfo->label) }}"></textarea>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <!-- Shipping Method -->
                                <div class="pb-30">
                                    <h4 class="fs-16 fw-600 lh-24 text-textBlack pb-15">{{ __('Shipping Info') }}
                                    </h4>
                                    <div class="bg-input-color mb-11">
                                        <div class="bg-body zForm-wrap-checkbox">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                   id="sameAsBillingBtn"/>
                                            <label class="form-check-label"
                                                   for="sameAsBillingBtn">{{ __('Same as Billing') }}</label>
                                        </div>
                                    </div>
                                    <div class="row rg-20 pb-15" id="shippingInfo">
                                        <div class="col-lg-6">
                                            <div class="zForm-wrap">
                                                <label class="zForm-label">{{ __('Address') }}</label>
                                                <input type="text" name="shipping_address"
                                                       class="form-control zForm-control"
                                                       placeholder="{{ __('Address') }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="zForm-wrap">
                                                <label class="zForm-label">{{ __('Zip Code') }}</label>
                                                <input type="text" name="shipping_zip_code"
                                                       class="form-control zForm-control"
                                                       placeholder="{{ __('Zip Code') }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="zForm-wrap">
                                                <label class="zForm-label">{{ __('City') }}</label>
                                                <input type="text" name="shipping_city"
                                                       class="form-control zForm-control"
                                                       placeholder="{{ __('City') }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="zForm-wrap">
                                                <label class="zForm-label">{{ __('State') }}</label>
                                                <input type="text" name="shipping_state"
                                                       class="form-control zForm-control"
                                                       placeholder="{{ __('State') }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="zForm-wrap">
                                                <label class="zForm-label">{{ __('Country') }}</label>
                                                <input type="text" name="shipping_country"
                                                       class="form-control zForm-control"
                                                       placeholder="{{ __('Country') }}"/>
                                            </div>
                                        </div>
                                        @if (json_decode($checkoutPage?->shipping_info))
                                            @foreach (json_decode($checkoutPage?->shipping_info) ?? [] as $shippingInfo)
                                                @if ($shippingInfo->type == 'text' || $shippingInfo->type == 'number' || $shippingInfo->type == 'email')
                                                    <div class="col-lg-6">
                                                        <div class="zForm-wrap">
                                                            <label
                                                                class="zForm-label">{{ __($shippingInfo->label) }}</label>
                                                            <input type="{{ $shippingInfo->type }}"
                                                                   name="shipping_info[{{ $shippingInfo->name }}]"
                                                                   class="form-control zForm-control"
                                                                   placeholder="{{ __($shippingInfo->label) }}"/>
                                                        </div>
                                                    </div>
                                                @elseif ($shippingInfo->type == 'textarea')
                                                    <div class="col-lg-6">
                                                        <div class="zForm-wrap">
                                                            <label
                                                                class="zForm-label">{{ __($shippingInfo->label) }}</label>
                                                            <textarea name="shipping_info[{{ $shippingInfo->name }}]"
                                                                      type="{{ $shippingInfo->type }}"
                                                                      class="form-control zForm-control"
                                                                      placeholder="{{ __($shippingInfo->label) }}"></textarea>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                    <h4 class="fs-16 fw-600 lh-24 text-textBlack pb-15">{{ __('Shipping Method') }}
                                    </h4>
                                    <div class="bd-one bd-c-stroke-color bd-ra-8 bg-input-color p-16">
                                        @if ($checkoutPage?->shipping_method == SHIPPING_METHOD_FREE)
                                            <div class="zForm-wrap-checkbox">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                       name="shipping_method" id="msShippingMethodFree" checked/>
                                                <label class="form-check-label"
                                                       for="msShippingMethodFree">{{ __('Free') }}</label>
                                            </div>
                                            <p class="pt-12 fs-14 fw-400 lh-17 text-para-text">
                                                {{ __('We deliver free to save you money') }}</p>
                                        @else
                                            <div class="zForm-wrap-checkbox">
                                                <input class="form-check-input" type="checkbox" value="2"
                                                       name="shipping_method" id="msShippingMethodFree" checked/>
                                                <label class="form-check-label"
                                                       for="msShippingMethodFree">{{ __('Paid') }}</label>
                                            </div>
                                            <p class="pt-12 fs-14 fw-400 lh-17 text-para-text">
                                                {{ __('We take your deliveries seriously.') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <!-- Payment Info -->
                                <div class="pb-30">
                                    <h4 class="fs-16 fw-600 lh-24 text-textBlack pb-15">{{ __('Payment Information') }}
                                    </h4>
                                    <!-- Tab -->
                                    <ul class="zTab-four d-flex checkoutPaymentItem">
                                        @foreach ($gateways as $key => $gateway)
                                            @if (in_array($gateway->id, json_decode($checkoutPage?->payment) ?? []))
                                                <li class="nav-item">
                                                    <button class="nav-link" type="button">
                                                        <label for="gateway{{ $key }}"><img
                                                                src="{{ asset($gateway->image) }}"/></label>
                                                        <input type="radio" value="{{ $gateway->id }}"
                                                               data-gateway="{{ $gateway->slug }}"
                                                               class="paymentGateway"
                                                               id="gateway{{ $key }}"/>
                                                    </button>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <!-- Button -->
                                <button type="submit"
                                        class="border-0 bd-ra-12 bg-main-color py-13 px-25 fs-16 fw-600 lh-19 text-white"
                                        id="paymentNowBtn">{{ __('Payment Now') }}
                                    <span id="gatewayCurrencyAmount"></span></button>
                            </div>
                            <!-- Right -->
                            <div class="d-flex flex-column rg-20 right">
                                <div class="right-wrap">
                                    <h4 class="fs-16 fw-600 lh-19 text-textBlack pb-15 mb-18 bd-b-one bd-c-stroke-color">
                                        {{ __('Purchase Details') }}</h4>
                                    <h4 class="fs-14 fw-400 lh-17 text-para-text pb-17">{{ __('Sass') }}</h4>
                                    <div class="bd-b-one bd-c-stroke-color pb-18 mb-18">
                                        <ul class="zList-pb-17">
                                            <li class="d-flex justify-content-between align-items-center">
                                                <p class="fs-14 fw-400 lh-17 text-para-text">{{ __('Plan Name') }}:</p>
                                                <p class="fs-14 fw-400 lh-17 text-para-text">{{ $plan->name }}</p>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center">
                                                <p class="fs-14 fw-400 lh-17 text-para-text">{{ __('Plan Code') }}:</p>
                                                <p class="fs-14 fw-400 lh-17 text-para-text">{{ $plan->code }}</p>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center">
                                                <p class="fs-14 fw-400 lh-17 text-para-text">{{ __('Quantity') }}:</p>
                                                <p class="fs-14 fw-400 lh-17 text-para-text">{{ __('01') }}</p>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center">
                                                <p class="fs-14 fw-400 lh-17 text-para-text">{{ __('Price') }}:</p>
                                                <p class="fs-14 fw-400 lh-17 text-para-text">{{ showPrice($plan->price) }}
                                                </p>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center">
                                                <p class="fs-14 fw-400 lh-17 text-para-text">{{ __('Shipping Charge') }}
                                                    :
                                                </p>
                                                <p class="fs-14 fw-400 lh-17 text-para-text">
                                                    {{ showPrice($plan->shipping_charge) }}
                                                </p>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center">
                                                <p class="fs-14 fw-400 lh-17 text-para-text">{{ __('Setup Fee') }}:</p>
                                                <p class="fs-14 fw-400 lh-17 text-para-text">
                                                    {{ showPrice($plan->setup_fee) }}
                                                </p>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center">
                                                <div class="input-group">
                                                    <input type="text" class="form-control zForm-control"
                                                           name="coupon_code" id="couponCode"
                                                           placeholder="{{ __('Coupon') }}">
                                                    <button type="button"
                                                            class="bg-main-color bg-yellow border-0 fs-16 fw-600 input-group-text lh-19 px-25 py-13 text-white"
                                                            id="couponCodeApplyBtn">{{ __('Apply') }}</button>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <ul class="zList-pb-17 bd-b-one bd-c-stroke-color pb-18 mb-18">
                                        <li class="d-flex justify-content-between align-items-center">
                                            <p class="fs-14 fw-600 lh-17 text-para-text">{{ __('Discount') }}:</p>
                                            <p class="fs-14 fw-600 lh-17 text-para-text" id="discountShowAmount">0</p>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center">
                                            <p class="fs-14 fw-600 lh-17 text-para-text">{{ __('Total') }}:</p>
                                            <p class="fs-14 fw-600 lh-17 text-para-text" id="totalShowAmount">
                                                {{ showPrice($plan->price + $plan->setup_fee + $plan->shipping_charge) }}
                                            </p>
                                        </li>
                                    </ul>
                                    <div class="">
                                        <ul class="zList-pb-17" id="gatewayCurrencyAppend"></ul>
                                    </div>
                                </div>
                                <div class="right-wrap d-none" id="bankSection">
                                    <h4 class="fs-16 fw-600 lh-19 text-textBlack pb-15 mb-18 bd-b-one bd-c-stroke-color">
                                        {{ __('Bank Deposit') }}</h4>
                                    <div class="zForm-wrap pb-20">
                                        <label for="bandDepositBankName"
                                               class="zForm-label">{{ __('Bank Name') }}</label>
                                        <select class="sf-select-two cs-select-form" id="bank_id" name="bank_id">
                                            <option value="">{{ __('Select Bank') }}</option>
                                            @foreach ($banks as $bank)
                                                <option value="{{ $bank->id }}"
                                                        data-details="{{ nl2br($bank->details) }}">{{ $bank->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p class="fs-14 fw-500 lh-17 text-textBlack p-10 mb-20 bd-one bd-c-stroke-color bd-ra-8 d-none"
                                       id="bankDetails"></p>
                                    <div class="zForm-wrap">
                                        <label for="bank_slip"
                                               class="zForm-label">{{ __('Upload Deposit Slip') }}</label>
                                        <input type="file" class="form-control zForm-control" id="bank_slip"
                                               name="bank_slip"/>
                                    </div>
                                </div>
                                @if($plan->details != null)
                                    <div class="right-wrap">
                                        <h4 class="fs-16 fw-600 lh-19 text-textBlack pb-15 mb-18 bd-b-one bd-c-stroke-color">
                                            {{ __('Plan Details') }}</h4>
                                        <div class="bd-c-stroke-color pb-18 mb-18">
                                            <p>{!! $plan->details !!}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="waitingRoute" value="{{ route('waiting') }}">
    <input type="hidden" id="planPrice" value="{{ $plan->price }}">
    <input type="hidden" id="planSetupFee" value="{{ $plan->setup_fee }}">
    <input type="hidden" id="planShippingCharge" value="{{ $plan->shipping_charge }}">
    <input type="hidden" id="discountAmount" value="0.00">
    <input type="hidden" id="planId" value="{{ $plan->id }}">
    <input type="hidden" id="userId" value="{{ $plan->user_id }}">
    <input type="hidden" id="getCouponInfoRoute" value="{{ route('get.coupon.info') }}">
    <input type="hidden" id="getCurrencyByGatewayRoute" value="{{ route('gateway.currency') }}">
@endsection

@push('style')
    <style>
        .zMain-checkout-content .title {
            font-size: {{ __($checkoutPage?->text_size) }};
            color: {{ __($checkoutPage?->text_color) }};
        }
    </style>
@endpush
@push('script')
    <script src="{{ asset('user/custom/js/checkout.js') }}"></script>
@endpush
