@extends('auth.layouts.app')

@push('title')
    {{ __('Forget Password') }}
@endpush

@section('content')
    <div class="zMain-signLog">
        <div class="zMain-signLog-wrap">
            <!-- Logo -->
            <div class="pb-34">
                <a href="{{route('frontend')}}" class="max-w-163"><img src="{{ getSettingImage('login_left_image') }}" alt="{{ getOption('app_name') }}" /></a>
            </div>
            <!--  -->
            <div class="pb-30">
                <h4 class="fs-32 fw-600 lh-40 text-textBlack pb-5">{{__("Reset Password")}}</h4>
                <h6 class="fs-14 fw-500 lh-24 text-para-text">{{__("Enter your email and instructions will sent to you!")}}</h6>
            </div>
            <!--  -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="zForm-wrap zForm-password pb-20">
                    <label for="resetPassword" class="zForm-label">{{__("Email")}}</label>
                    <input type="email" class="form-control zForm-control" id="email" name="email"
                           value="{{ old(' email') }}" placeholder="{{ __(' Your Email') }}" />
                </div>
                @error('email')
                <span class="fs-12 text-danger">{{ $message }}</span>
                @enderror
                <button type="submit" class="d-flex justify-content-center align-items-center w-100 p-13 border-0 bg-main-color bd-ra-10 fs-16 fw-600 lh-19 text-white mb-13">{{__("Send")}}</button>
            </form>
        </div>
    </div>
@endsection
