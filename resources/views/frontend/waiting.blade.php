@extends('frontend.layouts.app')
@push('title')
    {{ __('Request Sent Successfully! Wait for Approval') }}
@endpush
@section('content')
    <div class="zMain-signLog">
        <div class="zMain-thank">
            <div class="zMain-thank-wrap text-center">
                <div class="max-w-206 pb-22 m-auto"><img src="{{ asset('user/images/thanks.png') }}" alt="" /></div>
                <h4 class="pb-8 title">{{ __('Request Sent Successfully! Wait for Approval!') }}</h4>
                <p class="fs-14 fw-400 lh-24 text-para-text pb-13">
                    {{ __('Your request has been successfully sent. If you have any questions or need assistance, please don\'t hesitate to contact us.') }}
                </p>
            </div>
        </div>
    </div>
@endsection
