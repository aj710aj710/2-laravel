@extends('user.layouts.app')
@push('title')
    {{ __(@$pageTitle) }}
@endpush
@section('content')
    <div class="px-24 pb-24 position-relative">
        <div class="p-20 bd-one bd-c-stroke-color bd-ra-12 bg-white overflow-hidden">
            <div class="zTab-vertical-wrap">
                <div class="left">
                    <ul class="nav nav-tabs zTab-reset zTab-two" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="affiliate-tab" data-bs-toggle="tab"
                                data-bs-target="#affiliate-tab-pane" type="button" role="tab"
                                aria-controls="affiliate-tab-pane" aria-selected="true">{{ __('Affiliates') }}</button>
                            <span><i class="fa-solid fa-angle-right"></i></span>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="affiliateConfig-tab" data-bs-toggle="tab"
                                data-bs-target="#affiliateConfig-tab-pane" type="button" role="tab"
                                aria-controls="affiliateConfig-tab-pane"
                                aria-selected="true">{{ __('Affiliate Config') }}</button>
                            <span><i class="fa-solid fa-angle-right"></i></span>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="affiliateSignUpLink-tab" data-bs-toggle="tab"
                                data-bs-target="#affiliateSignUpLink-tab-pane" type="button" role="tab"
                                aria-controls="affiliateSignUpLink-tab-pane"
                                aria-selected="true">{{ __('Affiliate Sign Up Link') }}</button>
                            <span><i class="fa-solid fa-angle-right"></i></span>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="affiliateHistory-tab" data-bs-toggle="tab"
                                data-bs-target="#affiliateHistory-tab-pane" type="button" role="tab"
                                aria-controls="affiliateHistory-tab-pane"
                                aria-selected="true">{{ __('Affiliate History') }}</button>
                            <span><i class="fa-solid fa-angle-right"></i></span>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="withdrawHistory-tab" data-bs-toggle="tab"
                                data-bs-target="#withdrawHistory-tab-pane" type="button" role="tab"
                                aria-controls="withdrawHistory-tab-pane"
                                aria-selected="true">{{ __('Withdraw Request') }}</button>
                            <span><i class="fa-solid fa-angle-right"></i></span>
                        </li>
                    </ul>
                </div>
                <div class="right">
                    <div class="tab-content" id="myTabContentAffiliate">
                        <div class="tab-pane fade show active" id="affiliate-tab-pane" role="tabpanel"
                            aria-labelledby="affiliate-tab" tabindex="0">
                            <hr>
                            <table class="table zTable zTable-last-item-right" id="allAffiliateDataTable">
                                <thead>
                                    <tr>
                                        <th>
                                            <div>{{ __('#SL') }}</div>
                                        </th>
                                        <th>
                                            <div>{{ __('Name') }}</div>
                                        </th>
                                        <th>
                                            <div>{{ __('Email') }}</div>
                                        </th>
                                        <th>
                                            <div>{{ __('Status') }}</div>
                                        </th>
                                        <th>
                                            <div>{{ __('Action') }}</div>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="affiliateConfig-tab-pane" role="tabpanel"
                            aria-labelledby="affiliateConfig-tab" tabindex="0">
                            <div
                                class="d-flex pb-4 justify-content-between align-items-center flex-wrap rg-10 mb-22 border-b bd-c-stroke-2-color">
                                <h4 class="fs-18 fw-700 lh-24 text-textBlack bd-b-one border-0">
                                    {{ __('Affiliate Config') }}
                                </h4>
                                <div class="">
                                    <button
                                        class="border-0 bd-ra-12 bg-main-color py-13 px-25 fs-16 fw-600 lh-19 text-white"
                                        id="addAffiliateConfigBtn">{{ __('Add Affiliate Config') }}</button>
                                </div>
                            </div>
                            <hr>
                            <table class="table zTable zTable-last-item-right" id="allAffiliateConfigDataTable">
                                <thead>
                                    <tr>
                                        <th>
                                            <div>{{ __('#SL') }}</div>
                                        </th>
                                        <th>
                                            <div>{{ __('Title') }}</div>
                                        </th>
                                        <th>
                                            <div>{{ __('Product') }}</div>
                                        </th>
                                        <th>
                                            <div>{{ __('Plan') }}</div>
                                        </th>
                                        <th>
                                            <div>{{ __('Affiliate') }}</div>
                                        </th>
                                        <th>
                                            <div>{{ __('Amount') }}</div>
                                        </th>
                                        <th>
                                            <div>{{ __('Action') }}</div>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="affiliateSignUpLink-tab-pane" role="tabpanel"
                            aria-labelledby="affiliateSignUpLink-tab" tabindex="0">
                            <div
                                class="d-flex pb-4 justify-content-between align-items-center flex-wrap rg-10 mb-22 border-b bd-c-stroke-2-color">
                                <h4 class="fs-18 fw-700 lh-24 text-textBlack bd-b-one border-0">
                                    {{ __('Affiliate Sign Up Link') }}
                                </h4>
                            </div>
                            <hr>
                            <table class="table zTable-1">
                                <thead>
                                    <tr>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Link"
                                                value="{{ route('affiliate.register.form', auth()->user()->uuid) }}">
                                            <button type="button" class="btn btn-success input-group-text copyLink"
                                                data-link="{{ route('affiliate.register.form', auth()->user()->uuid) }}"
                                                id="basic-addon2">{{ __('Copy Link') }}</button>
                                        </div>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="withdrawHistory-tab-pane" role="tabpanel"
                            aria-labelledby="withdrawHistory-tab" tabindex="0">
                            @include('user.affiliate.partials.request')
                        </div>

                        <div class="tab-pane fade" id="affiliateHistory-tab-pane" role="tabpanel"
                            aria-labelledby="affiliateHistory-tab" tabindex="0">
                            <div
                                class="d-flex pb-4 justify-content-between align-items-center flex-wrap rg-10 mb-22 border-b bd-c-stroke-2-color">
                                <h4 class="fs-18 fw-700 lh-24 text-textBlack bd-b-one border-0">
                                    {{ __('Affiliate History') }}
                                </h4>
                            </div>
                            @include('user.affiliate.partials.history')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addAffiliateConfigModal" tabindex="-1" aria-labelledby="addAffiliateConfigModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">
                <div class="d-flex justify-content-between align-items-center cg-10 pb-16">
                    <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{ __('Add Affiliate Config') }}</h4>
                    <button type="button"
                        class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
                        data-bs-dismiss="modal" aria-label="Close"><img
                            src="{{ asset('user/images/icon/close.svg') }}" />
                    </button>
                </div>
                <form class="ajax reset-form" action="{{ route('user.affiliate.config.store') }}" method="POST"
                    data-handler="commonResponse">
                    @csrf
                    <div class="row">
                        <div class="col-12 pb-25">
                            <div class="zForm-wrap">
                                <label for="invoiceTotalProductAmount" class="zForm-label">{{ __('Title') }}</label>
                                <input type="text" name="title" class="form-control zForm-control"
                                    placeholder="{{ __('Title') }}" />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="zForm-wrap pb-20">
                                <label class="zForm-label">{{ __('Products') }}</label>
                                <select class="sf-select-two cs-select-form product_id" name="product_ids[]" multiple>
                                    <option value="all">{{ __('All Products') }}</option>
                                    @foreach ($allProducts as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="zForm-wrap pb-20">
                                <label class="zForm-label">{{ __('Plans') }}</label>
                                <select class="sf-select-two cs-select-form plan-append-data" name="plan_ids[]" multiple>
                                    <option value="all">{{ __('All Plans') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="zForm-wrap pb-20">
                                <label class="zForm-label">{{ __('Affiliates') }}</label>
                                <select class="sf-select-two cs-select-form affiliate_id" name="affiliate_ids[]" multiple>
                                    <option value="all">{{ __('All Affiliates') }}</option>
                                    @foreach ($allAffiliates as $affiliate)
                                        <option value="{{ $affiliate->id }}">
                                            {{ $affiliate->name }}({{ $affiliate->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center cg-10">
                                <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{ __('Commission') }}</h4>
                            </div>
                            <hr>
                        </div>
                        <div class="col-12">
                            <div class="row mb-2">
                                <div class="col-lg-6">
                                    <div class="zForm-wrap">
                                        <label class="zForm-label">{{ __('First Payment') }}</label>
                                        <div class="input-group">
                                            <select class="form-select" name="commission_type">
                                                <option value="1">{{ __('Flat') }}</option>
                                                <option value="2">{{ __('Percent') }}</option>
                                            </select>
                                            <input type="text" step="any" min="0"
                                                class="form-control zForm-control" placeholder="{{ __('Amount') }}"
                                                name="commission_amount" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="zForm-wrap">
                                        <label class="zForm-label">{{ __('Recurring Payment') }}</label>
                                        <div class="input-group">
                                            <select class="form-select" name="recurring_commission_type">
                                                <option value="1">{{ __('Flat') }}</option>
                                                <option value="2">{{ __('Percent') }}</option>
                                            </select>
                                            <input type="number" step="any" min="0"
                                                class="form-control zForm-control rounded-end"
                                                placeholder="{{ __('Amount') }}" name="recurring_commission_amount" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                        class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">{{ __('Submit') }}</button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editAffiliateConfigModal" tabindex="-1" aria-labelledby="editAffiliateConfigModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">
                <div class="d-flex justify-content-between align-items-center cg-10 pb-16">
                    <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{ __('Edit Affiliate Config') }}</h4>
                    <button type="button"
                        class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
                        data-bs-dismiss="modal" aria-label="Close"><img
                            src="{{ asset('user/images/icon/close.svg') }}" />
                    </button>
                </div>
                <form class="ajax reset-form" action="{{ route('user.affiliate.config.store') }}" method="POST"
                    data-handler="commonResponse">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="row">
                        <div class="col-12 pb-25">
                            <div class="zForm-wrap">
                                <label for="invoiceTotalProductAmount" class="zForm-label">{{ __('Title') }}</label>
                                <input type="text" name="title" class="form-control zForm-control"
                                    placeholder="{{ __('Title') }}" />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="zForm-wrap pb-20">
                                <label class="zForm-label">{{ __('Products') }}</label>
                                <select class="sf-select-two cs-select-form product_id" name="product_ids[]" multiple>
                                    <option value="all">{{ __('All Products') }}</option>
                                    @foreach ($allProducts as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="zForm-wrap pb-20">
                                <label class="zForm-label">{{ __('Plans') }}</label>
                                <select class="sf-select-two cs-select-form plan-append-data plan_id" name="plan_ids[]"
                                    multiple>
                                    <option value="all">{{ __('All Plans') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="zForm-wrap pb-20">
                                <label class="zForm-label">{{ __('Affiliates') }}</label>
                                <select class="sf-select-two cs-select-form affiliate_id" name="affiliate_ids[]" multiple>
                                    <option value="all">{{ __('All Affiliates') }}</option>
                                    @foreach ($allAffiliates as $affiliate)
                                        <option value="{{ $affiliate->id }}">
                                            {{ $affiliate->name }}({{ $affiliate->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center cg-10">
                                <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{ __('Commission') }}</h4>
                            </div>
                            <hr>
                        </div>
                        <div class="col-12">
                            <div class="row mb-2">
                                <div class="col-lg-6">
                                    <div class="zForm-wrap">
                                        <label class="zForm-label">{{ __('First Payment') }}</label>
                                        <div class="input-group">
                                            <select class="form-select" name="commission_type">
                                                <option value="1">{{ __('Flat') }}</option>
                                                <option value="2">{{ __('Percent') }}</option>
                                            </select>
                                            <input type="text" step="any" min="0"
                                                class="form-control zForm-control" placeholder="{{ __('Amount') }}"
                                                name="commission_amount" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="zForm-wrap">
                                        <label class="zForm-label">{{ __('Recurring Payment') }}</label>
                                        <div class="input-group">
                                            <select class="form-select" name="recurring_commission_type">
                                                <option value="1">{{ __('Flat') }}</option>
                                                <option value="2">{{ __('Percent') }}</option>
                                            </select>
                                            <input type="number" step="any" min="0"
                                                class="form-control zForm-control rounded-end"
                                                placeholder="{{ __('Amount') }}" name="recurring_commission_amount" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                        class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">{{ __('Update') }}</button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="statusAffiliateConfigModal" tabindex="-1"
        aria-labelledby="statusAffiliateConfigModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">
                <div class="d-flex justify-content-between align-items-center cg-10 pb-16">
                    <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{ __('Status Affiliate') }}</h4>
                    <button type="button"
                        class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
                        data-bs-dismiss="modal" aria-label="Close"><img
                            src="{{ asset('user/images/icon/close.svg') }}" />
                    </button>
                </div>
                <form class="ajax reset-form" action="{{ route('user.affiliate.status.change') }}" method="POST"
                    data-handler="commonResponse">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="zForm-wrap pb-20">
                                <label class="zForm-label">{{ __('Status') }}</label>
                                <select class="sf-select-without-search cs-select-form" name="status">
                                    <option value="0">{{ __('Pending') }}</option>
                                    <option value="1">{{ __('Approve') }}</option>
                                    <option value="4">{{ __('Deactivate') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                        class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">{{ __('Update') }}</button>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="edit-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">

            </div>
        </div>
    </div>

    <input type="hidden" id="getPlanByProductRoute" value="{{ route('user.get.plan.by.product') }}">
    <input type="hidden" id="affiliateIndexRoute" value="{{ route('user.affiliate.index') }}">
    <input type="hidden" id="affiliateConfigListRoute" value="{{ route('user.affiliate.config.list') }}">
    <input type="hidden" id="getAffiliateConfigInfoRoute" value="{{ route('user.affiliate.config.info') }}">
    <input type="hidden" id="getAffiliateInfoRoute" value="{{ route('user.affiliate.info') }}">
    <input type="hidden" id="affiliateHistoryRoute" value="{{ route('user.affiliate.history') }}">
    <input type="hidden" id="ordersStatusRoute" value="{{ route('user.affiliate.withdraw.request.status') }}">
@endsection

@push('style')
    <style>
        .sf-select-section.select2-selection--multiple .select2-selection__rendered .select2-selection__choice {
            margin-top: 6px;
            background-color: var(--purple-light) !important;
            border-color: var(--purple-light) !important;
            color: var(--main-color) !important;
        }

        .sf-select-section.select2-selection--multiple .select2-selection__rendered .select2-selection__choice .select2-selection__choice__remove {
            border-color: var(--purple-light) !important;
            color: var(--main-color);
        }
    </style>
@endpush

@push('script')
    <script src="{{ asset('user/custom/js/affiliate.js') }}"></script>
@endpush
