@extends('user.layouts.app')
@push('title')
    {{ __(@$pageTitle) }}
@endpush
@section('content')
    <div class="px-24 pb-24 position-relative">
        <!--  -->
        <div class="p-20 bd-one bd-c-stroke-color bd-ra-12 bg-white overflow-hidden">
            <div class="zTab-vertical-wrap">
                <!-- Left -->
                <div class="left">
                    @include('user.settings.sidebar')
                </div>
                <!-- Right -->
                <div class="right">
                    <div class="tab-content" id="myTabContent">
                        <!-- Account Settings -->
                        <div class="tab-pane fade show active" id="accountSettings-tab-pane" role="tabpanel"
                            aria-labelledby="accountSettings-tab" tabindex="0">
                            <form action="{{ route('user.settings.profile.update') }}" method="POST" class="ajax reset"
                                data-handler="commonResponseWithPageLoad">
                                @csrf
                                <h4 class="fs-18 fw-700 lh-24 text-textBlack pb-19 mb-19 bd-b-one bd-c-stroke-color">
                                    {{ __('Personal Information') }}</h4>
                                <!-- Photo -->
                                <div class="pb-30">
                                    <div class="upload-img-box profileImage-upload">
                                        <div class="icon">
                                            <img src="{{ asset('user/images/icon/camera.svg') }}" />
                                        </div>
                                        <img src="{{ getFileUrl($user->image) }}" />
                                        <input type="file" name="image" id="zImageUpload" accept="image/*"
                                            onchange="previewFile(this)" />
                                    </div>
                                </div>
                                <!-- Inputs -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="zForm-wrap pb-20">
                                            <label for="name" class="zForm-label">{{ __('Name') }}</label>
                                            <input type="text" name="name" class="form-control zForm-control"
                                                id="name" value="{{ $user->name }}"
                                                placeholder="{{ __('Name') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="zForm-wrap pb-20">
                                            <label for="email" class="zForm-label">{{ __('Email') }}</label>
                                            <input type="email" name="email" class="form-control zForm-control"
                                                id="email" value="{{ $user->email }}"
                                                placeholder="{{ __('Email') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="zForm-wrap pb-20">
                                            <label for="mobile" class="zForm-label">{{ __('Phone') }}</label>
                                            <input type="text" name="mobile" class="form-control zForm-control"
                                                id="mobile" value="{{ $user->mobile }}"
                                                placeholder="{{ __('Phone') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="zForm-wrap pb-20">
                                            <label class="zForm-label">{{ __('Currency') }}</label>
                                            <select class="sf-select-two cs-select-form" name="currency">
                                                @foreach (getCurrency() as $key => $currency)
                                                    <option value="{{ $key }}"
                                                        {{ $user->currency == $key ? 'selected' : '' }}>
                                                        {{ $currency }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="zForm-wrap pb-20">
                                            <label for="country" class="zForm-label">{{ __('Country') }}</label>
                                            <input type="text" name="country" class="form-control zForm-control"
                                                id="country" value="{{ $user->country }}"
                                                placeholder="{{ __('Country') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="zForm-wrap pb-20">
                                            <label for="city" class="zForm-label">{{ __('City') }}</label>
                                            <input type="text" name="city" class="form-control zForm-control"
                                                id="city" value="{{ $user->city }}"
                                                placeholder="{{ __('City') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="zForm-wrap pb-20">
                                            <label for="zip_code" class="zForm-label">{{ __('Zip Code') }}</label>
                                            <input type="text" name="zip_code" class="form-control zForm-control"
                                                id="zip_code" value="{{ $user->zip_code }}"
                                                placeholder="{{ __('Zip Code') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="zForm-wrap pb-20">
                                            <label for="address" class="zForm-label">{{ __('Address') }}</label>
                                            <input type="text" name="address" class="form-control zForm-control"
                                                id="address" value="{{ $user->address }}"
                                                placeholder="{{ __('Address') }}" />
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                                <h4 class="fs-18 fw-700 lh-24 text-textBlack pb-19 mb-19 bd-b-one bd-c-stroke-color">
                                    {{ __('Organization Details') }}</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="zForm-wrap pb-20">
                                            <label for="cName" class="zForm-label">{{ __('Company Name') }}</label>
                                            <input type="text" name="company_name" class="form-control zForm-control"
                                                id="cName" value="{{ $user->company_name }}"
                                                placeholder="{{ __('Company Name') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="zForm-wrap pb-20">
                                            <label for="cDesignation" class="zForm-label">{{ __('Designation') }}</label>
                                            <input type="text" name="company_designation"
                                                class="form-control zForm-control" id="cDesignation"
                                                value="{{ $user->company_designation }}"
                                                placeholder="{{ __('Designation') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="zForm-wrap pb-20">
                                            <label for="cCountry" class="zForm-label">{{ __('Country') }}</label>
                                            <input type="text" name="company_country"
                                                class="form-control zForm-control" id="cCountry"
                                                value="{{ $user->company_country }}"
                                                placeholder="{{ __('Country') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="zForm-wrap pb-20">
                                            <label for="cCity" class="zForm-label">{{ __('City') }}</label>
                                            <input type="text" name="company_city" class="form-control zForm-control"
                                                id="cCity" value="{{ $user->company_city }}"
                                                placeholder="{{ __('City') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="zForm-wrap pb-20">
                                            <label for="cZipCode" class="zForm-label">{{ __('Zip Code') }}</label>
                                            <input type="text" name="company_zip_code"
                                                class="form-control zForm-control" id="cZipCode"
                                                value="{{ $user->company_zip_code }}"
                                                placeholder="{{ __('Zip Code') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="zForm-wrap pb-20">
                                            <label for="cAddress" class="zForm-label">{{ __('Address') }}</label>
                                            <input type="text" name="company_address"
                                                class="form-control zForm-control" id="cAddress"
                                                value="{{ $user->company_address }}"
                                                placeholder="{{ __('Address') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="zForm-wrap pb-20">
                                            <label for="uploadDepositSlip"
                                                class="zForm-label">{{ __('Company Logo') }}</label>
                                            <input type="file" name="company_logo" class="form-control zForm-control"
                                                id="uploadDepositSlip">
                                        </div>
                                    </div>
                                </div>
                                <h4 class="fs-18 fw-700 lh-24 text-textBlack pb-19 mb-19 bd-b-one bd-c-stroke-color">
                                    {{ __('Change Password') }}</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="zForm-wrap pb-20">
                                            <label for="cName" class="zForm-label">{{ __('Password') }}</label>
                                            <input type="password" name="pass1" class="form-control zForm-control"
                                                id="cName" value=""
                                                placeholder="{{ __('Re Enter Password') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="zForm-wrap pb-20">
                                            <label for="cDesignation" class="zForm-label">{{ __('Re Password') }}</label>
                                            <input type="password" name="pass2" class="form-control zForm-control"
                                                id="cDesignation" value=""
                                                placeholder="{{ __('Re Enter Password') }}" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Buttons -->
                                <div class="d-flex align-items-center cg-10">
                                    <button
                                        class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">{{ __('Update') }}</button>
                                </div>
                            </form>
                        </div>
                        <!-- Checkout page settings -->
                        <div class="tab-pane fade" id="checkoutPageSettings-tab-pane" role="tabpanel"
                            aria-labelledby="checkoutPageSettings-tab" tabindex="0">
                            <!--  -->
                            <div
                                class="d-flex justify-content-between align-items-center flex-wrap g-10 bd-b-one bd-c-stroke-2-color pb-20 mb-15">
                                <div>
                                    <h4 class="fs-18 fw-700 lh-24 text-textBlack pb-5">{{ __('Checkout Page Settings') }}
                                    </h4>
                                </div>
                            </div>
                            <!-- Multi form -->
                            <div id="msform">
                                <ul id="progressbar">
                                    <li class="active">{{ __('Header Settings') }}</li>
                                    <li>{{ __('Basic Info') }}</li>
                                    <li>{{ __('Billing Info') }}</li>
                                    <li>{{ __('Shipping Info') }}</li>
                                    <li>{{ __('Payment Info') }}</li>
                                    <li>{{ __('Confirmation') }}</li>
                                </ul>
                                <!-- Header settings -->
                                <fieldset>
                                    <form class="ajax" action="{{ route('user.settings.checkout.page.update') }}"
                                        method="POST" data-handler="getCheckoutPageUpdateRes">
                                        @csrf
                                        <input type="hidden" name="step" class="d-none" value="1">
                                        <div>
                                            <h4 class="fs-16 fw-600 lh-24 text-textBlack pb-15">
                                                {{ __('Header Settings') }}
                                            </h4>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="zForm-wrap zImage-upload-details mb-20">
                                                        <div class="zImage-inside">
                                                            <div class="d-flex pb-12">
                                                                <img
                                                                    src="{{ asset('user/images/icon/cloud-upload.svg') }}" />
                                                            </div>
                                                            <p class="fs-15 fw-500 lh-16 text-1b1c17">
                                                                {{ __('Drag & Drop Files Here') }}</p>
                                                        </div>
                                                        <label for="zImageUpload"
                                                            class="zForm-label">{{ __('Upload Image') }}</label>
                                                        <div class="upload-img-box">
                                                            @if ($checkoutPage)
                                                                <img src="{{ getFileUrl($checkoutPage?->image) }}" />
                                                            @endif
                                                            <input type="file" name="image" id="zImageUpload"
                                                                accept="image/*,video/*" onchange="previewFile(this)" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row rg-20 pb-25">
                                                <div class="col-lg-6">
                                                    <div class="zForm-wrap">
                                                        <label for="msHeaderTitle"
                                                            class="zForm-label">{{ __('Header Title') }}</label>
                                                        <input type="text" class="form-control zForm-control"
                                                            name="title" id="msHeaderTitle"
                                                            value="{{ $checkoutPage?->title }}"
                                                            placeholder="{{ __('Header Title') }}" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="zForm-wrap">
                                                        <label for="msHeaderTextSize"
                                                            class="zForm-label">{{ __('Header Text Size') }}</label>
                                                        <input type="text" class="form-control zForm-control"
                                                            name="text_size" id="msHeaderTextSize"
                                                            value="{{ $checkoutPage?->text_size }}"
                                                            placeholder="{{ __('16px') }}" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="zForm-wrap">
                                                        <label for="msHeaderTextColor"
                                                            class="zForm-label">{{ __('Header Text Color') }}</label>
                                                        <input type="text" class="form-control zForm-control"
                                                            name="text_color" id="msHeaderTextColor"
                                                            value="{{ $checkoutPage?->text_color }}"
                                                            placeholder="{{ __('Hex') }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit"
                                            class="action-button nextStep1">{{ __('Save & Next') }}</button>
                                    </form>
                                </fieldset>
                                <!-- Basic Info -->
                                <fieldset>
                                    <form class="ajax" action="{{ route('user.settings.checkout.page.update') }}"
                                        method="POST" data-handler="getCheckoutPageUpdateRes">
                                        @csrf
                                        <input type="hidden" name="step" class="d-none" value="2">
                                        <div>
                                            <h4 class="fs-16 fw-600 lh-24 text-textBlack pb-15">{{ __('Basic Info') }}
                                            </h4>
                                            <div class="row rg-20 pb-25">
                                                <div class="col-lg-12 basicInfoAppend">
                                                    <div class="row mb-2">
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Type') }}</label>
                                                                <select class="form-control zForm-control" disabled>
                                                                    <option value="text">{{ __('Text') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Label') }}</label>
                                                                <input type="" class="form-control zForm-control"
                                                                    value="First Name" disabled />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Placeholder') }}</label>
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control zForm-control rounded"
                                                                        value="First Name" disabled />
                                                                    <button type="button"
                                                                        class="bg-white border-0 input-group-text text-default"
                                                                        disabled>
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Type') }}</label>
                                                                <select class="form-control zForm-control" disabled>
                                                                    <option value="text">{{ __('Text') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Label') }}</label>
                                                                <input type="" class="form-control zForm-control"
                                                                    value="Last Name" disabled />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Placeholder') }}</label>
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control zForm-control rounded"
                                                                        value="Last Name" disabled />
                                                                    <button type="button"
                                                                        class="bg-white border-0 input-group-text text-default"
                                                                        disabled>
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Type') }}</label>
                                                                <select class="form-control zForm-control" disabled>
                                                                    <option value="">{{ __('Email') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Label') }}</label>
                                                                <input type="text" class="form-control zForm-control"
                                                                    value="Email" disabled />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Placeholder') }}</label>
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control zForm-control rounded"
                                                                        value="Email" disabled />
                                                                    <button type="button"
                                                                        class="bg-white border-0 input-group-text text-default"
                                                                        disabled>
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Type') }}</label>
                                                                <select class="form-control zForm-control" disabled>
                                                                    <option value="">{{ __('Text') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Label') }}</label>
                                                                <input type="text" class="form-control zForm-control"
                                                                    value="Phone" disabled />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Placeholder') }}</label>
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control zForm-control rounded"
                                                                        value="Phone" disabled />
                                                                    <button type="button"
                                                                        class="bg-white border-0 input-group-text text-default"
                                                                        disabled>
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Type') }}</label>
                                                                <select class="form-control zForm-control" disabled>
                                                                    <option value="">{{ __('Text') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Label') }}</label>
                                                                <input type="text" class="form-control zForm-control"
                                                                    value="Company" disabled />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label
                                                                    class="zForm-label">{{ __('Placeholder') }}</label>
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control zForm-control rounded"
                                                                        value="Company" disabled />
                                                                    <button type="button"
                                                                        class="bg-white border-0 input-group-text text-default"
                                                                        disabled>
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @foreach (json_decode($checkoutPage?->basic_info) ?? [] as $basicInfo)
                                                        <div class="row mb-2">
                                                            <div class="col-lg-4">
                                                                <div class="zForm-wrap">
                                                                    <label
                                                                        class="zForm-label">{{ __('Type') }}</label>
                                                                    <select class="form-control zForm-control basic-type"
                                                                        name="basic[type][]">
                                                                        <option value="text"
                                                                            {{ $basicInfo->type == 'text' ? 'selected' : '' }}>
                                                                            {{ __('Text') }}
                                                                        </option>
                                                                        <option value="number"
                                                                            {{ $basicInfo->type == 'number' ? 'selected' : '' }}>
                                                                            {{ __('Number') }}
                                                                        </option>
                                                                        <option value="textarea"
                                                                            {{ $basicInfo->type == 'textarea' ? 'selected' : '' }}>
                                                                            {{ __('Textarea') }}
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="zForm-wrap">
                                                                    <label
                                                                        class="zForm-label">{{ __('Label') }}</label>
                                                                    <input type="text"
                                                                        class="form-control zForm-control basic-label"
                                                                        name="basic[label][]"
                                                                        value="{{ $basicInfo->label }}"
                                                                        placeholder="{{ __('Label') }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="zForm-wrap">
                                                                    <label
                                                                        class="zForm-label">{{ __('Placeholder') }}</label>
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                            class="form-control zForm-control rounded basic-placeholder"
                                                                            name="basic[placeholder][]"
                                                                            value="{{ $basicInfo->placeholder }}"
                                                                            placeholder="{{ __('Placeholder') }}" />
                                                                        <button type="button"
                                                                            class="bg-white border-0 input-group-text removeInfoBtn text-danger">
                                                                            <i class="fa-solid fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="col-12">
                                                    <button type="button"
                                                        class="border-0 p-0 bg-transparent fs-14 fw-500 lh-17 text-main-color addBasicInfoFieldBtn">{{ __('+Add Info') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="button" name="previous" class="previousBtn action-button-previous"
                                            value="Previous" />
                                        <button type="submit"
                                            class="action-button nextStep2">{{ __('Save & Next') }}</button>
                                    </form>
                                </fieldset>
                                <!-- Billing Info -->
                                <fieldset>
                                    <form class="ajax" action="{{ route('user.settings.checkout.page.update') }}"
                                        method="POST" data-handler="getCheckoutPageUpdateRes">
                                        @csrf
                                        <input type="hidden" name="step" class="d-none" value="3">
                                        <div>
                                            <h4 class="fs-16 fw-600 lh-24 text-textBlack pb-15">{{ __('Billing Info') }}
                                            </h4>
                                            <div class="row rg-20 pb-25">
                                                <div class="col-lg-12 billingInfoAppend">
                                                    <div class="row mb-2">
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Type') }}</label>
                                                                <select class="form-control zForm-control" disabled>
                                                                    <option value="text">{{ __('Text') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Label') }}</label>
                                                                <input type="" class="form-control zForm-control"
                                                                    value="Address" disabled />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label
                                                                    class="zForm-label">{{ __('Placeholder') }}</label>
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control zForm-control rounded"
                                                                        value="Address" disabled />
                                                                    <button type="button"
                                                                        class="bg-white border-0 input-group-text text-default"
                                                                        disabled>
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Type') }}</label>
                                                                <select class="form-control zForm-control" disabled>
                                                                    <option value="text">{{ __('Text') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Label') }}</label>
                                                                <input type="" class="form-control zForm-control"
                                                                    value="Zip Code" disabled />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label
                                                                    class="zForm-label">{{ __('Placeholder') }}</label>
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control zForm-control rounded"
                                                                        value="Zip Code" disabled />
                                                                    <button type="button"
                                                                        class="bg-white border-0 input-group-text text-default"
                                                                        disabled>
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Type') }}</label>
                                                                <select class="form-control zForm-control" disabled>
                                                                    <option value="text">{{ __('Text') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Label') }}</label>
                                                                <input type="" class="form-control zForm-control"
                                                                    value="City" disabled />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label
                                                                    class="zForm-label">{{ __('Placeholder') }}</label>
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control zForm-control rounded"
                                                                        value="City" disabled />
                                                                    <button type="button"
                                                                        class="bg-white border-0 input-group-text text-default"
                                                                        disabled>
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Type') }}</label>
                                                                <select class="form-control zForm-control" disabled>
                                                                    <option value="text">{{ __('Text') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Label') }}</label>
                                                                <input type="" class="form-control zForm-control"
                                                                    value="State" disabled />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label
                                                                    class="zForm-label">{{ __('Placeholder') }}</label>
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control zForm-control rounded"
                                                                        value="State" disabled />
                                                                    <button type="button"
                                                                        class="bg-white border-0 input-group-text text-default"
                                                                        disabled>
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Type') }}</label>
                                                                <select class="form-control zForm-control" disabled>
                                                                    <option value="text">{{ __('Text') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Label') }}</label>
                                                                <input type="" class="form-control zForm-control"
                                                                    value="Country" disabled />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label
                                                                    class="zForm-label">{{ __('Placeholder') }}</label>
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control zForm-control rounded"
                                                                        value="Country" disabled />
                                                                    <button type="button"
                                                                        class="bg-white border-0 input-group-text text-default"
                                                                        disabled>
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @foreach (json_decode($checkoutPage?->billing_info) ?? [] as $billingInfo)
                                                        <div class="row mb-2">
                                                            <div class="col-lg-4">
                                                                <div class="zForm-wrap">
                                                                    <label
                                                                        class="zForm-label">{{ __('Type') }}</label>
                                                                    <select class="form-control zForm-control billing-type"
                                                                        name="billing[type][]">
                                                                        <option value="text"
                                                                            {{ $billingInfo->type == 'text' ? 'selected' : '' }}>
                                                                            {{ __('Text') }}
                                                                        </option>
                                                                        <option value="number"
                                                                            {{ $billingInfo->type == 'number' ? 'selected' : '' }}>
                                                                            {{ __('Number') }}
                                                                        </option>
                                                                        <option value="textarea"
                                                                            {{ $billingInfo->type == 'textarea' ? 'selected' : '' }}>
                                                                            {{ __('Textarea') }}
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="zForm-wrap">
                                                                    <label
                                                                        class="zForm-label">{{ __('Label') }}</label>
                                                                    <input type="text"
                                                                        class="form-control zForm-control billing-label"
                                                                        name="billing[label][]"
                                                                        value="{{ $billingInfo->label }}"
                                                                        placeholder="{{ __('Label') }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="zForm-wrap">
                                                                    <label
                                                                        class="zForm-label">{{ __('Placeholder') }}</label>
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                            class="form-control zForm-control rounded billing-placeholder"
                                                                            name="billing[placeholder][]"
                                                                            value="{{ $billingInfo->placeholder }}"
                                                                            placeholder="{{ __('Placeholder') }}" />
                                                                        <button type="button"
                                                                            class="bg-white border-0 input-group-text removeInfoBtn text-danger">
                                                                            <i class="fa-solid fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="col-12">
                                                    <button type="button"
                                                        class="border-0 p-0 bg-transparent fs-14 fw-500 lh-17 text-main-color addBillingInfoFieldBtn">{{ __('+Add Info') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="button" name="previous" class="previousBtn action-button-previous"
                                            value="Previous" />
                                        <button type="submit"
                                            class="action-button nextStep3">{{ __('Save & Next') }}</button>
                                    </form>
                                </fieldset>
                                <!-- Shipping Info -->
                                <fieldset>
                                    <form class="ajax" action="{{ route('user.settings.checkout.page.update') }}"
                                        method="POST" data-handler="getCheckoutPageUpdateRes">
                                        @csrf
                                        <input type="hidden" name="step" class="d-none" value="4">
                                        <div>
                                            <h4 class="fs-16 fw-600 lh-24 text-textBlack pb-15">{{ __('Shipping Info') }}
                                            </h4>
                                            <div class="row rg-20 pb-25">
                                                <div class="col-lg-12 shippingInfoAppend">
                                                    <div class="row mb-2">
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Type') }}</label>
                                                                <select class="form-control zForm-control" disabled>
                                                                    <option value="text">{{ __('Text') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Label') }}</label>
                                                                <input type="" class="form-control zForm-control"
                                                                    value="Address" disabled />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label
                                                                    class="zForm-label">{{ __('Placeholder') }}</label>
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control zForm-control rounded"
                                                                        value="Address" disabled />
                                                                    <button type="button"
                                                                        class="bg-white border-0 input-group-text text-default"
                                                                        disabled>
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Type') }}</label>
                                                                <select class="form-control zForm-control" disabled>
                                                                    <option value="text">{{ __('Text') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Label') }}</label>
                                                                <input type="" class="form-control zForm-control"
                                                                    value="Zip Code" disabled />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label
                                                                    class="zForm-label">{{ __('Placeholder') }}</label>
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control zForm-control rounded"
                                                                        value="Zip Code" disabled />
                                                                    <button type="button"
                                                                        class="bg-white border-0 input-group-text text-default"
                                                                        disabled>
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Type') }}</label>
                                                                <select class="form-control zForm-control" disabled>
                                                                    <option value="text">{{ __('Text') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Label') }}</label>
                                                                <input type="" class="form-control zForm-control"
                                                                    value="City" disabled />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label
                                                                    class="zForm-label">{{ __('Placeholder') }}</label>
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control zForm-control rounded"
                                                                        value="City" disabled />
                                                                    <button type="button"
                                                                        class="bg-white border-0 input-group-text text-default"
                                                                        disabled>
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Type') }}</label>
                                                                <select class="form-control zForm-control" disabled>
                                                                    <option value="text">{{ __('Text') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Label') }}</label>
                                                                <input type="" class="form-control zForm-control"
                                                                    value="State" disabled />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label
                                                                    class="zForm-label">{{ __('Placeholder') }}</label>
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control zForm-control rounded"
                                                                        value="State" disabled />
                                                                    <button type="button"
                                                                        class="bg-white border-0 input-group-text text-default"
                                                                        disabled>
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Type') }}</label>
                                                                <select class="form-control zForm-control" disabled>
                                                                    <option value="text">{{ __('Text') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label class="zForm-label">{{ __('Label') }}</label>
                                                                <input type="" class="form-control zForm-control"
                                                                    value="Country" disabled />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="zForm-wrap">
                                                                <label
                                                                    class="zForm-label">{{ __('Placeholder') }}</label>
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control zForm-control rounded"
                                                                        value="Country" disabled />
                                                                    <button type="button"
                                                                        class="bg-white border-0 input-group-text text-default"
                                                                        disabled>
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @foreach (json_decode($checkoutPage?->shipping_info) ?? [] as $shippingInfo)
                                                        <div class="row mb-2">
                                                            <div class="col-lg-4">
                                                                <div class="zForm-wrap">
                                                                    <label
                                                                        class="zForm-label">{{ __('Type') }}</label>
                                                                    <select
                                                                        class="form-control zForm-control shipping-type"
                                                                        name="shipping[type][]">
                                                                        <option value="text"
                                                                            {{ $shippingInfo->type == 'text' ? 'selected' : '' }}>
                                                                            {{ __('Text') }}
                                                                        </option>
                                                                        <option value="number"
                                                                            {{ $shippingInfo->type == 'number' ? 'selected' : '' }}>
                                                                            {{ __('Number') }}
                                                                        </option>
                                                                        <option value="textarea"
                                                                            {{ $shippingInfo->type == 'textarea' ? 'selected' : '' }}>
                                                                            {{ __('Textarea') }}
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="zForm-wrap">
                                                                    <label
                                                                        class="zForm-label">{{ __('Label') }}</label>
                                                                    <input type="text"
                                                                        class="form-control zForm-control shipping-label"
                                                                        name="shipping[label][]"
                                                                        value="{{ $shippingInfo->label }}"
                                                                        placeholder="{{ __('Label') }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="zForm-wrap">
                                                                    <label
                                                                        class="zForm-label">{{ __('Placeholder') }}</label>
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                            class="form-control zForm-control rounded shipping-placeholder"
                                                                            name="shipping[placeholder][]"
                                                                            value="{{ $shippingInfo->placeholder }}"
                                                                            placeholder="{{ __('Placeholder') }}" />
                                                                        <button type="button"
                                                                            class="bg-white border-0 input-group-text removeInfoBtn text-danger">
                                                                            <i class="fa-solid fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="col-12">
                                                    <button type="button"
                                                        class="border-0 p-0 bg-transparent fs-14 fw-500 lh-17 text-main-color addShippingInfoFieldBtn">{{ __('+Add Info') }}</button>
                                                </div>
                                            </div>
                                            <h4 class="fs-16 fw-600 lh-24 text-textBlack pb-15">
                                                {{ __('Shipping Method') }}
                                            </h4>
                                            <div class="row rg-20 pb-25">
                                                <div class="col-lg-6">
                                                    <div class="bd-one bd-c-stroke-color bd-ra-8 bg-input-color p-16">
                                                        <div class="zForm-wrap-checkbox">
                                                            <input class="form-check-input" type="radio" value="1"
                                                                id="msShippingMethodFree" name="shipping_method"
                                                                {{ $checkoutPage?->shipping_method == SHIPPING_METHOD_FREE ? 'checked' : '' }} />
                                                            <label class="form-check-label"
                                                                for="msShippingMethodFree">{{ __('Free') }}</label>
                                                        </div>
                                                        <p class="pt-12 fs-14 fw-400 lh-17 text-para-text">
                                                            {{ __('We deliver free to save you money') }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="bd-one bd-c-stroke-color bd-ra-8 bg-input-color p-16">
                                                        <div class="zForm-wrap-checkbox">
                                                            <input class="form-check-input" type="radio" value="2"
                                                                id="msShippingMethodFastDelivery" name="shipping_method"
                                                                {{ $checkoutPage?->shipping_method == SHIPPING_METHOD_PAID ? 'checked' : '' }} />
                                                            <label class="form-check-label"
                                                                for="msShippingMethodFastDelivery">{{ __('Paid') }}</label>
                                                        </div>
                                                        <p class="pt-12 fs-14 fw-400 lh-17 text-para-text">
                                                            {{ __('We take your deliveries seriously.') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="button" name="previous" class="previousBtn action-button-previous"
                                            value="Previous" />
                                        <button type="submit"
                                            class="action-button nextStep4">{{ __('Save & Next') }}</button>
                                    </form>
                                </fieldset>
                                <!-- Payment Selection -->
                                <fieldset>
                                    <form class="ajax" action="{{ route('user.settings.checkout.page.update') }}"
                                        method="POST" data-handler="getCheckoutPageUpdateRes">
                                        @csrf
                                        <input type="hidden" name="step" class="d-none" value="5">
                                        <div>
                                            <h4 class="fs-16 fw-600 lh-24 text-textBlack pb-20">
                                                {{ __('Payment Selection') }}
                                            </h4>
                                            <div class="pb-40 d-flex align-items-center flex-wrap rg-25 cg-10">
                                                @foreach ($gateways as $key => $gateway)
                                                    <div class="position-relative flex-grow-1 max-w-419 w-100">
                                                        <div
                                                            class="zForm-wrap-radio py-13 px-15 bd-one bd-c-stroke-2-color bd-ra-8 bg-input-color">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="{{ $gateway->id }}"
                                                                id="checkoutPaymentItemStripe{{ $key }}"
                                                                {{ in_array($gateway->id, json_decode($checkoutPage?->payment) ?? []) ? 'checked' : '' }}
                                                                name="gateways[]" />
                                                            <label class="form-check-label"
                                                                for="checkoutPaymentItemStripe{{ $key }}">{{ $gateway->title }}</label>
                                                        </div>
                                                        <div
                                                            class="position-absolute top-50 end-0 translate-middle-y pr-15">
                                                            <img src="{{ asset($gateway->image) }}" alt="" />
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <input type="button" name="previous" class="previousBtn action-button-previous"
                                            value="Previous" />
                                        <button type="submit"
                                            class="action-button nextStep5">{{ __('Save & Next') }}</button>
                                    </form>
                                </fieldset>
                                <!-- Confirmation Selection -->
                                <fieldset>
                                    <form class="ajax" action="{{ route('user.settings.checkout.page.update') }}"
                                        method="POST" data-handler="getCheckoutPageUpdateRes">
                                        @csrf
                                        <input type="hidden" name="step" class="d-none" value="6">
                                        <div>
                                            <h4 class="fs-16 fw-600 lh-24 text-textBlack pb-20">{{ __('Details') }}</h4>
                                            <div class="d-flex flex-column rg-20 pb-25">
                                                <!-- Basic Info -->
                                                <div class="py-23 px-28 bd-ra-8 bg-secondary-color">
                                                    <h4 class="fs-16 fw-600 lh-24 text-textBlack pb-11">
                                                        {{ __('Basic Info') }}</h4>
                                                    <p class="fs-14 fw-500 lh-24 text-para-text">
                                                        {{ __('First Name') }}:<span
                                                            class="fw-400">{{ __('Text') }}</span>
                                                    </p>
                                                    <p class="fs-14 fw-500 lh-24 text-para-text">
                                                        {{ __('Last Name') }}:<span
                                                            class="fw-400">{{ __('Text') }}</span>
                                                    </p>
                                                    <p class="fs-14 fw-500 lh-24 text-para-text">
                                                        {{ __('Email') }}:<span
                                                            class="fw-400">{{ __('Email') }}</span>
                                                    </p>
                                                    <p class="fs-14 fw-500 lh-24 text-para-text">
                                                        {{ __('Phone') }}:<span
                                                            class="fw-400">{{ __('Text') }}</span>
                                                    </p>
                                                    <p class="fs-14 fw-500 lh-24 text-para-text">
                                                        {{ __('Company') }}:<span
                                                            class="fw-400">{{ __('Text') }}</span>
                                                    </p>
                                                    @foreach (json_decode($checkoutPage?->basic_info) ?? [] as $basicInfo)
                                                        <p class="fs-14 fw-500 lh-24 text-para-text">
                                                            {{ $basicInfo->label }}
                                                            :
                                                            <span class="fw-400">{{ $basicInfo->type }}</span>
                                                        </p>
                                                    @endforeach
                                                </div>
                                                <!-- Billing Info -->
                                                <div class="py-23 px-28 bd-ra-8 bg-secondary-color">
                                                    <h4 class="fs-16 fw-600 lh-24 text-textBlack pb-11">
                                                        {{ __('Billing Info') }}</h4>
                                                    <p class="fs-14 fw-500 lh-24 text-para-text">
                                                        {{ __('Address') }}:<span
                                                            class="fw-400">{{ __('Text') }}</span>
                                                    </p>
                                                    <p class="fs-14 fw-500 lh-24 text-para-text">
                                                        {{ __('Zip Code') }}:<span
                                                            class="fw-400">{{ __('Text') }}</span>
                                                    </p>
                                                    <p class="fs-14 fw-500 lh-24 text-para-text">
                                                        {{ __('City') }}:<span
                                                            class="fw-400">{{ __('Text') }}</span>
                                                    </p>
                                                    <p class="fs-14 fw-500 lh-24 text-para-text">
                                                        {{ __('State') }}:<span
                                                            class="fw-400">{{ __('Text') }}</span>
                                                    </p>
                                                    <p class="fs-14 fw-500 lh-24 text-para-text">
                                                        {{ __('Country') }}:<span
                                                            class="fw-400">{{ __('Text') }}</span>
                                                    </p>
                                                    @foreach (json_decode($checkoutPage?->billing_info) ?? [] as $billingInfo)
                                                        <p class="fs-14 fw-500 lh-24 text-para-text">
                                                            {{ $billingInfo->label }}
                                                            :
                                                            <span class="fw-400">{{ $billingInfo->type }}</span>
                                                        </p>
                                                    @endforeach
                                                </div>
                                                <!-- Shipping Info -->
                                                <div class="py-23 px-28 bd-ra-8 bg-secondary-color">
                                                    <h4 class="fs-16 fw-600 lh-24 text-textBlack pb-15">
                                                        {{ __('Shipping Address') }}</h4>
                                                    <p class="fs-14 fw-500 lh-24 text-para-text">
                                                        {{ __('First Name') }}:<span
                                                            class="fw-400">{{ __('Text') }}</span>
                                                    </p>
                                                    <p class="fs-14 fw-500 lh-24 text-para-text">
                                                        {{ __('Last Name') }}:<span
                                                            class="fw-400">{{ __('Text') }}</span>
                                                    </p>
                                                    <p class="fs-14 fw-500 lh-24 text-para-text">
                                                        {{ __('Email') }}:<span
                                                            class="fw-400">{{ __('Text') }}</span>
                                                    </p>
                                                    <p class="fs-14 fw-500 lh-24 text-para-text">
                                                        {{ __('Phone') }}:<span
                                                            class="fw-400">{{ __('Text') }}</span>
                                                    </p>
                                                    <p class="fs-14 fw-500 lh-24 text-para-text">
                                                        {{ __('Address') }}:<span
                                                            class="fw-400">{{ __('Text') }}</span>
                                                    </p>
                                                    <div class="pb-20">
                                                        @foreach (json_decode($checkoutPage?->shipping_info) ?? [] as $shippingInfo)
                                                            <p class="fs-14 fw-500 lh-24 text-para-text">
                                                                {{ $shippingInfo->label }}
                                                                : <span class="fw-400">{{ $shippingInfo->type }}</span>
                                                            </p>
                                                        @endforeach
                                                    </div>
                                                    <div>
                                                        <h4 class="fs-12 fw-600 lh-24 text-textBlack">
                                                            {{ __('Shipping Method') }}</h4>
                                                        <p class="fs-14 fw-500 lh-24 text-para-text">
                                                            {{ $checkoutPage?->shipping_method == SHIPPING_METHOD_FREE ? __('Free') : __('Paid') }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <!-- Payment -->
                                                <div>
                                                    <h4 class="fs-16 fw-600 lh-19 text-textBlack pb-20">
                                                        {{ __('Payment Gateway') }}</h4>
                                                    <div id="gatewaysShow">
                                                    </div>
                                                </div>
                                                <div>
                                                    <h4 class="fs-16 fw-600 lh-19 text-textBlack pb-20">
                                                        {{ __('Status') }}</h4>
                                                    <div class="col-lg-4">
                                                        <div class="zForm-wrap">
                                                            <select class="form-control zForm-control info-type"
                                                                name="status">
                                                                <option value="1"
                                                                    {{ $checkoutPage?->status == CHECKOUT_PAGE_SETTING_STATUS_ACTIVE ? 'selected' : '' }}>
                                                                    {{ __('Active') }}</option>
                                                                <option value="2"
                                                                    {{ $checkoutPage?->status != CHECKOUT_PAGE_SETTING_STATUS_ACTIVE ? 'selected' : '' }}>
                                                                    {{ __('Inactive') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="button" name="previous" class="previousBtn action-button-previous"
                                            value="Previous" />
                                        <button type="submit"
                                            class="action-button nextStep6">{{ __('Confirm') }}</button>
                                    </form>
                                </fieldset>
                            </div>
                        </div>
                        <!-- Email Notification -->
                        <div class="tab-pane fade" id="emailNotification-tab-pane" role="tabpanel"
                            aria-labelledby="emailNotification-tab" tabindex="0">
                            <!--  -->
                            <h4 class="fs-18 fw-700 lh-24 text-textBlack pb-30">{{ __('Email Template Settings') }}
                                <button
                                    class="border-0 bd-ra-12 bg-main-color py-13 px-25 fs-16 fw-600 lh-19 text-white testEmail"
                                    data-bs-toggle="modal" data-bs-target="#emailTestModal"
                                    fdprocessedid="sjjvzc">{{ __('Test') }}</button>
                            </h4>
                            <!-- List -->
                            <ul class="zList-pb-20">
                                @foreach (emailTemplates() as $key => $template)
                                    <li>
                                        <input type="hidden" name="category" value="{{ $key }}">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap g-10">
                                            <div>
                                                <h5 class="fs-14 fw-500 lh-17 text-textBlack pb-7">
                                                    {{ __($template['title']) }}
                                                </h5>
                                                <p class="fs-12 fw-400 lh-16 text-para-text">
                                                    {{ __($template['details']) }}
                                                </p>
                                            </div>
                                            <div class="d-flex align-items-center flex-wrap cg-47 rg-10">
                                                <div class="zCheck form-check form-switch">
                                                    <input class="form-check-input templateStatus" type="checkbox"
                                                        {{ emailTemplateStatus($key) == ACTIVE ? 'checked' : '' }}
                                                        role="switch" />
                                                </div>
                                                <button type="button"
                                                    class="fs-14 fw-500 lh-17 text-main-color text-decoration-underline btn templateConfigure">{{ __('Configure') }}</button>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- Webhooks -->
                        <div class="tab-pane fade" id="webhooks-tab-pane" role="tabpanel" aria-labelledby="webhooks-tab"
                            tabindex="0">

                            <div
                                class="d-flex pb-4 justify-content-between align-items-center flex-wrap rg-10 mb-22 border-b bd-c-stroke-2-color">
                                <h4 class="fs-18 fw-700 lh-24 text-textBlack bd-b-one border-0">{{ __('Webhook') }}
                                </h4>
                                <div class="">
                                    <button
                                        class="border-0 bd-ra-12 bg-main-color py-13 px-25 fs-16 fw-600 lh-19 text-white webhookModalBtn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#webhookModal">{{ __('Add Webhook') }}</button>
                                </div>
                            </div>

                            <hr>

                            <!-- Table -->
                            <table class="table zTable zTable-last-item-right" id="webhookTable">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <div class="min-w-150">{{ __('Webhook Name') }}</div>
                                        </th>
                                        <th scope="col">
                                            <div class="min-w-150">{{ __('Webhook URL') }}</div>
                                        </th>
                                        <th scope="col">
                                            <div class="min-w-100">{{ __('Product') }}</div>
                                        </th>
                                        <th scope="col">
                                            <div class="min-w-100">{{ __('Plan') }}</div>
                                        </th>
                                        <th scope="col">
                                            <div>{{ __('status') }}</div>
                                        </th>
                                        <th scope="col">
                                            <div>{{ __('Action') }}</div>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- Invoice settings -->
                        <div class="tab-pane fade" id="invoiceSettings-tab-pane" role="tabpanel"
                            aria-labelledby="invoiceSettings-tab" tabindex="0">
                            <form class="ajax" action="{{ route('user.settings.invoice.update') }}" method="POST"
                                data-handler="getShowMessage">
                                @csrf
                                <div class="pb-30">
                                    <div class="row rg-20">
                                        <div class="col-xl-6 col-md-12">
                                            <div class="zForm-wrap zImage-upload-details mb-20">
                                                <div class="zImage-inside">
                                                    <div class="d-flex pb-12">
                                                        <img src="{{ asset('user/images/icon/cloud-upload.svg') }}" />
                                                    </div>
                                                    <p class="fs-15 fw-500 lh-16 text-1b1c17">
                                                        {{ __('Drag & Drop Files Here') }}</p>
                                                </div>
                                                <label for="zImageUploadLogo"
                                                    class="fs-18 fw-600 lh-24 text-textBlack pb-15">{{ __('Logo') }}</label>
                                                <div class="upload-img-box">
                                                    @if ($invoiceSetting)
                                                        <img src="{{ getFileUrl($invoiceSetting?->logo) }}" />
                                                    @endif
                                                    <input type="file" name="logo" id="zImageUploadLogo"
                                                        accept="image/*" onchange="previewFile(this)" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-30">
                                    <div class="row rg-20">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="zForm-wrap">
                                                <h4 class="fs-18 fw-600 lh-24 text-textBlack pb-15">{{ __('Title') }}
                                                </h4>
                                                <input type="text" class="form-control zForm-control" name="title"
                                                    value="{{ $invoiceSetting?->title }}"
                                                    placeholder="{{ __('Title') }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-15 bg-purple-light bd-ra-10 d-flex flex-wrap cg-4 rg-5 mb-25">
                                                @foreach (invoiceSettingFields() as $field)
                                                    <span
                                                        class="px-9 bg-white rounded-pill fs-12 fw-400 lh-24 text-textBlack">{{ $field }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-30">
                                    <div class="row rg-20">
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="zForm-wrap">
                                                <h4 class="fs-18 fw-600 lh-24 text-textBlack pb-15">
                                                    {{ __('Company Information') }}</h4>
                                                <textarea name="company_info" class="form-control zForm-control summernoteOne">{{ $invoiceSetting?->company_info }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-30">
                                    <div class="row rg-20">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="zForm-wrap">
                                                <h4 class="fs-18 fw-600 lh-24 text-textBlack pb-15">{{ __('Prefix') }}
                                                </h4>
                                                <input type="text" class="form-control zForm-control" name="prefix"
                                                    value="{{ $invoiceSetting?->prefix }}"
                                                    placeholder="{{ __('Prefix') }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-30">
                                    <div class="row rg-20">
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="zForm-wrap">
                                                <h4 class="fs-18 fw-600 lh-24 text-textBlack pb-15">
                                                    {{ __('Information One') }}</h4>
                                                <textarea name="info_one" class="form-control zForm-control summernoteOne">{{ $invoiceSetting?->info_one }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-30">
                                    <div class="row rg-20">
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="zForm-wrap">
                                                <h4 class="fs-18 fw-600 lh-24 text-textBlack pb-15">
                                                    {{ __('Information Two') }}</h4>
                                                <textarea name="info_two" class="form-control zForm-control summernoteOne">{{ $invoiceSetting?->info_two }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-30">
                                    <div class="row rg-20">
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="zForm-wrap">
                                                <h4 class="fs-18 fw-600 lh-24 text-textBlack pb-15">
                                                    {{ __('Information Three') }}</h4>
                                                <textarea name="info_three" class="form-control zForm-control summernoteOne">{{ $invoiceSetting?->info_three }}</textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="pb-30">
                                    <div class="row rg-20">
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="zForm-wrap">
                                                <h4 class="fs-18 fw-600 lh-24 text-textBlack pb-15">
                                                    {{ __('Footer Text') }}</h4>
                                                <textarea name="footer_text" class="form-control zForm-control summernoteOne">{{ $invoiceSetting?->footer_text }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-30">
                                    <div class="row rg-20">
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="zForm-wrap pb-20">
                                                <h4 class="fs-18 fw-600 lh-24 text-textBlack pb-15">
                                                    {{ __('Show Column') }}</h4>
                                                <div class="d-flex align-items-center flex-wrap g-10">
                                                    @foreach (getTableColumn() as $key => $column)
                                                        <div
                                                            class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                                                            <input class="form-check-input"
                                                                value="{{ $key }}" type="checkbox"
                                                                id="tableColumn{{ $key }}"
                                                                {{ in_array($key, json_decode($invoiceSetting?->column) ?? []) ? 'checked' : '' }}
                                                                name="column[]">
                                                            <label class="form-check-label"
                                                                for="tableColumn{{ $key }}">{{ $column }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Buttons -->
                                <div class="d-flex align-items-center cg-10">
                                    <button
                                        class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">{{ __('Update') }}</button>
                                </div>
                            </form>
                        </div>

                        <!-- Tax Tab start-->
                        <div class="tab-pane fade" id="tax-tab-pane" role="tabpanel" aria-labelledby="tax-tab"
                            tabindex="0">
                            <div
                                class="d-flex pb-4 justify-content-between align-items-center mb-22 border-b bd-c-stroke-2-color">
                                <h4 class="fs-18 fw-700 lh-24 text-textBlack bd-b-one border-0">{{ __('Tax Settings') }}
                                </h4>
                                <div class="">
                                    <button
                                        class="border-0 bd-ra-12 bg-main-color py-13 px-25 fs-16 fw-600 lh-19 text-white testEmail taxModalBtn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#taxModal">{{ __('Add Rule') }}</button>
                                </div>
                            </div>

                            <hr>

                            <input type="hidden" id="settingsTaxRoute" value="{{ route('user.settings') }}">
                            <!-- Table -->
                            <table class="table zTable pt-2 zTable-last-item-right" id="taxDataTable">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <div class="min-w-120">{{ __('Rule Name') }}</div>
                                        </th>
                                        <th scope="col">
                                            <div class="min-sm-w-150">{{ __('Product') }}</div>
                                        </th>
                                        <th scope="col">
                                            <div class="min-sm-w-100">{{ __('Plans') }}</div>
                                        </th>
                                        <th scope="col">
                                            <div class="min-w-120">{{ __('Tax Amount') }}</div>
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
                        <!-- Tax Tab end-->

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- tax add modal start --}}
    <div class="modal fade" id="taxModal" tabindex="-1" aria-labelledby="taxModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">
                <div class="d-flex justify-content-between align-items-center cg-10 pb-16">
                    <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{ __('Add Tax') }}</h4>
                    <button type="button"
                        class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
                        data-bs-dismiss="modal" aria-label="Close"><img
                            src="{{ asset('user') }}/images/icon/close.svg" alt="" />
                    </button>
                </div>
                <form class="ajax reset-form" action="{{ route('user.settings.tax.store') }}" method="POST"
                    data-handler="commonResponse">
                    @csrf
                    <div class="col-12 pb-25">
                        <div class="zForm-wrap">
                            <label for="invoiceTotalProductAmount" class="zForm-label">{{ __('Rule Title') }}</label>
                            <input type="text" name="tax_rule_name" class="form-control zForm-control"
                                placeholder="{{ __('Tax Rule') }}" />
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="zForm-wrap pb-20">
                            <label class="zForm-label">{{ __('Select Product') }}</label>
                            <select class="sf-select-two cs-select-form" id="product-id" name="product_id">
                                <option>{{ __('Select Product') }}</option>
                                @foreach ($allProducts as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="zForm-wrap pb-20">
                            <label class="zForm-label">{{ __('Select Plan') }}</label>
                            <select class="sf-select-two plan-filter-data" name="plan_id">
                                <option value="">{{ __('Select Plan') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="zForm-wrap pb-20">
                        <label for="eInputCouponDiscountType" class="zForm-label">{{ __('Tax Type') }}</label>
                        <div class="d-flex align-items-center flex-wrap g-10">
                            <div class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                                <input class="form-check-input" value="{{ DISCOUNT_TYPE_FLAT }}" type="radio"
                                    id="couponDiscountTypeFlat" name="tax_type" />
                                <label class="form-check-label"
                                    for="couponDiscountTypeFlat">{{ __('Flat') }}</label>
                            </div>
                            <div class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                                <input value="{{ DISCOUNT_TYPE_PERCENT }}" class="form-check-input" type="radio"
                                    id="couponDiscountTypePercent" name="tax_type" />
                                <label class="form-check-label"
                                    for="couponDiscountTypePercent">{{ __('Percent') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 pb-25">
                        <div class="zForm-wrap">
                            <label for="invoiceTotalProductAmount" class="zForm-label">{{ __('Tax Amount') }}</label>
                            <input type="text" name="tax_amount" class="form-control zForm-control"
                                placeholder="0.00 (%)" />
                        </div>
                    </div>
                    <button type="submit"
                        class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">{{ __('Save Now') }}</button>
                </form>
            </div>
        </div>
    </div>
    {{-- tax add modal end --}}

    {{-- tax edit modal start --}}
    <div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="taxModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">

            </div>
        </div>
    </div>
    {{-- tax edit modal end --}}

    {{-- modal  --}}
    <div class="modal fade" id="emailConfigureModal" tabindex="-1" aria-labelledby="emailConfigureModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">
                <div>
                    <h4 class="fs-18 fw-700 lh-24 text-textBlack pb-27">{{ __('Edit Email Template') }}</h4>
                    <form class="ajax" action="{{ route('user.settings.email.template.config.update') }}"
                        method="POST" data-handler="commonResponse">
                        @csrf
                        <input type="hidden" name="category">
                        <div class="p-15 bg-purple-light bd-ra-10 d-flex flex-wrap cg-4 rg-5 mb-25 templateFields"></div>
                        <div class="zForm-wrap pb-20">
                            <label for="subject" class="zForm-label">{{ __('Subject') }}</label>
                            <input type="text" class="form-control zForm-control" id="subject" name="subject"
                                placeholder="{{ __('Subject') }}" />
                        </div>
                        <div class="zForm-wrap pb-20">
                            <label for="body" class="zForm-label">{{ __('Body') }}</label>
                            <textarea class="form-control summernoteOne" id="body" name="body" placeholder="{{ __('Body') }}"></textarea>
                        </div>
                        <div class="d-flex align-items-center cg-10">
                            <button type="submit"
                                class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">{{ __('Update') }}</button>
                            <button type="button"
                                class="border-0 bd-ra-12 py-13 px-25 bg-cancel-color fs-16 fw-600 lh-19 text-textBlack"
                                data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="emailTestModal" tabindex="-1" aria-labelledby="emailTestModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">
                <div>
                    <!--  -->
                    <h4 class="fs-18 fw-700 lh-24 text-textBlack pb-27">{{ __('Test Email') }}</h4>
                    <form class="ajax" action="{{ route('user.settings.email.test') }}" method="POST"
                        data-handler="commonResponse">
                        @csrf
                        <div class="zForm-wrap pb-20">
                            <label for="email" class="zForm-label">{{ __('Email') }}</label>
                            <input type="email" class="form-control zForm-control" id="email" name="email"
                                placeholder="{{ __('Email') }}" />
                        </div>
                        <div class="zForm-wrap pb-20">
                            <label for="subject" class="zForm-label">{{ __('Template') }}</label>
                            <select class="sf-select-two cs-select-form" name="category">
                                @foreach (emailTemplates() as $key => $template)
                                    <option value="{{ $key }}">{{ __($template['title']) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex align-items-center cg-10">
                            <button type="submit"
                                class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">{{ __('Send') }}</button>
                            <button type="button"
                                class="border-0 bd-ra-12 py-13 px-25 bg-cancel-color fs-16 fw-600 lh-19 text-textBlack"
                                data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addFieldMultiformModal" tabindex="-1" aria-labelledby="addFieldMultiformModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">
                <!--  -->
                <div class="d-flex justify-content-between align-items-center cg-10 pb-16">
                    <h4 class="fs-18 fw-600 lh-24 text-textBlack">Basic Information</h4>
                    <button type="button"
                        class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
                        data-bs-dismiss="modal" aria-label="Close"><img
                            src="{{ asset('user/images/icon/close.svg') }}" alt="" /></button>
                </div>
                <!--  -->
                <form>
                    <div class="zForm-wrap pb-20">
                        <label for="mfModalFirstName" class="zForm-label">First Name<span
                                class="text-red">*</span></label>
                        <input type="text" class="form-control zForm-control" id="mfModalFirstName"
                            placeholder="Enter First Name" />
                    </div>
                    <div class="zForm-wrap pb-20">
                        <label for="mfModalLastName" class="zForm-label">Last Name<span
                                class="text-red">*</span></label>
                        <input type="text" class="form-control zForm-control" id="mfModalLastName"
                            placeholder="Enter Last Name" />
                    </div>
                    <div class="zForm-wrap pb-20">
                        <label for="mfModalEmail" class="zForm-label">Email<span class="text-red">*</span></label>
                        <input type="email" class="form-control zForm-control" id="mfModalEmail"
                            placeholder="Enter Email" />
                    </div>
                    <div class="zForm-wrap pb-20">
                        <label for="mfModalPhoneNumber" class="zForm-label">Phone Number<span
                                class="text-red">*</span></label>
                        <input type="number" class="form-control zForm-control" id="mfModalPhoneNumber"
                            placeholder="Enter Phone Number" />
                    </div>
                    <div class="zForm-wrap pb-20">
                        <div class="d-flex justify-content-between align-items-center pb-11">
                            <label for="mfModalCompanyName" class="zForm-label mb-0">Company Name<span
                                    class="text-red">*</span></label>
                            <div class="zForm-wrap-checkbox">
                                <label class="form-check-label" for="mfModalNeeded1">Needed</label>
                                <input class="form-check-input" type="checkbox" value="" id="mfModalNeeded1"
                                    checked />
                            </div>
                        </div>
                        <input type="number" class="form-control zForm-control" id="mfModalCompanyName"
                            placeholder="Enter Company Name" />
                    </div>
                    <div class="zForm-wrap pb-20">
                        <div class="d-flex justify-content-between align-items-center pb-11">
                            <label for="mfModalWebsite" class="zForm-label">Website<span
                                    class="text-red">*</span></label>
                            <div class="zForm-wrap-checkbox">
                                <label class="form-check-label" for="mfModalNeeded2">Needed</label>
                                <input class="form-check-input" type="checkbox" value=""
                                    id="mfModalNeeded2" />
                            </div>
                        </div>
                        <input type="number" class="form-control zForm-control" id="mfModalWebsite"
                            placeholder="Enter Website" />
                    </div>
                    <button type="button"
                        class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">Save
                        Changes</button>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="webhookModal" tabindex="-1" aria-labelledby="taxModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">
                <div>
                    <h4 class="fs-18 fw-700 lh-24 text-textBlack pb-27">{{ __('Add Webhook') }}</h4>
                    <form class="ajax reset-form" action="{{ route('user.webhook.store') }}" method="POST"
                        data-handler="settingCommonHandler">
                        @csrf
                        <div class="col-12 pb-25">
                            <div class="zForm-wrap">
                                <label for="invoiceTotalProductAmount"
                                    class="zForm-label">{{ __('Webhook Name') }}</label>
                                <input type="text" name="webhook_name" class="form-control zForm-control"
                                    placeholder="{{ __('Webhook Name') }}" />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="zForm-wrap pb-20">
                                <label class="zForm-label">{{ __('Select Product') }}</label>
                                <select class="sf-select-two cs-select-form product-change-action" name="product_id">
                                    <option>{{ __('Select Product') }}</option>
                                    @foreach ($allProducts as $product)
                                        <option value="{{ $product->id }}">
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="zForm-wrap pb-20">
                                <label class="zForm-label">{{ __('Select Plan') }}</label>
                                <select class="sf-select-two plan-filter-data-for-webhook" name="plan_id">
                                    <option value="">{{ __('Select Plan') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 pb-25">
                            <div class="zForm-wrap">
                                <label for="invoiceTotalProductAmount"
                                    class="zForm-label">{{ __('Webhook URL') }}</label>
                                <input type="text" name="webhook_url" class="form-control zForm-control"
                                    placeholder="" />
                            </div>
                        </div>
                        <button type="submit"
                            class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">{{ __('Save Now') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit-webhook-modal" tabindex="-1" aria-labelledby="taxModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">

            </div>
        </div>
    </div>


    <input type="hidden" id="gateways" value="{{ json_encode($gateways) }}">
    <input type="hidden" id="emailTemplateConfigRoute" value="{{ route('user.settings.email.template.config') }}">
    <input type="hidden" id="emailTemplateStatus" value="{{ route('user.settings.email.template.status') }}">
    <input type="hidden" id="settingsRoute" value="{{ route('user.settings') }}">
    <input type="hidden" id="webhookTableRoute" value="{{ route('user.webhook.list') }}">
    <input type="hidden" id="plan-route" value="{{ route('user.settings.get.plan.data') }}">
@endsection
@push('script')
    <script src="{{ asset('user/custom/js/webhook.js') }}"></script>
    <script src="{{ asset('user/custom/js/tax.js') }}"></script>
    <script src="{{ asset('user/custom/js/settings.js') }}"></script>
@endpush
