@extends('layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')
    <div class="p-30">
        <div class="">
            <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{ __($pageTitle) }}</h4>
            <div class="row">
                <div class="col-xxl-2 col-lg-3 col-md-4 pr-0">
                    <div class="bd-c-ebedf0 bd-half bd-ra-25 bg-white h-100 p-30">
                        @include('admin.setting.partials.general-sidebar')
                    </div>
                </div>
                <div class="col-xxl-10 col-lg-9 col-md-8">
                    <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                        <div class="email-inbox__area bg-style form-horizontal__item bg-style admin-general-settings-page">
                            <div class="item-top mb-30">
                                <h4>{{ $pageTitle }}</h4>
                            </div>
                            <form class="ajax" action="{{ route('admin.setting.application-settings.update') }}"
                                method="POST" enctype="multipart/form-data" data-handler="settingCommonHandler">
                                @csrf
                                <div class="row">
                                    <div class="col-xxl-6 col-lg-6">
                                        <div class="primary-form-group my-2 pt-3">
                                            <div class="primary-form-group-wrap">
                                                <label class="form-label">{{ __('Active Status') }}</label>
                                                <select name="affiliate_status"
                                                    class="sf-select-without-search primary-form-control">
                                                    <option value="1"
                                                        {{ getOption('affiliate_status', 0) == 1 ? 'selected' : '' }}>
                                                        {{ __('Enable') }}</option>
                                                    <option value="0"
                                                        {{ getOption('affiliate_status', 0) != 1 ? 'selected' : '' }}>
                                                        {{ __('Disable') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input__group general-settings-btn text-end">
                                            <button type="submit"
                                                class="bd-ra-12 bg-7f56d9 border-0 fw-500 lh-25 text-white px-26 py-10">{{ __('Update') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
