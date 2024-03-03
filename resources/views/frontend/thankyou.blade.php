@extends('frontend.layouts.app')
@push('title')
    {{ __('Thank you') }}
@endpush
@section('content')
    <div class="zMain-signLog">
        <div class="zMain-thank">
            <div class="zMain-thank-wrap text-center">
                <div class="max-w-206 pb-22 m-auto"><img src="{{ asset('user/images/thanks.png') }}" alt="" /></div>
                <h4 class="pb-8 title">{{ __('Thank you for your payment') }}</h4>
                <p class="fs-14 fw-400 lh-24 text-para-text pb-13">
                    {{ __('Your payment has been successfully processed. If you have any questions or need assistance, please don\'t hesitate to contact us.') }}
                </p>
            </div>
        </div>
    </div>
@endsection
