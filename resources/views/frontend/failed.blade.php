@extends('frontend.layouts.app')
@push('title')
    {{ __('Failed') }}
@endpush
@section('content')
    <div class="zMain-signLog">
        <div class="zMain-thank">
            <div class="zMain-thank-wrap text-center">
                <div class="max-w-206 pb-22 m-auto"><img src="{{ asset('user/images/error.png') }}" alt="" /></div>
                <h4 class="pb-8 title">{{ __('Payment Failed') }}</h4>
                <p class="fs-14 fw-400 lh-24 text-para-text pb-13">
                    {{ __('We apologize, but it seems there was an issue processing your payment. Please check the following details: Payment Information, Sufficient Funds, Payment Method, Billing Address') }}
                </p>
            </div>
        </div>
    </div>
@endsection
