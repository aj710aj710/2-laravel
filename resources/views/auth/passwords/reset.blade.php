@extends('auth.layouts.app')
@push('title')
    {{ __('Reset Password') }}
@endpush
@section('content')
    <div class="zMain-signLog">
        <div class="zMain-signLog-wrap">
            <div class="pb-34">
                <a href="{{ route('frontend') }}" class="max-w-163"><img src="{{ getSettingImage('app_logo') }}"
                        alt="{{ getOption('app_name') }}" /></a>
            </div>
            <div class="pb-30">
                <h4 class="fs-32 fw-600 lh-40 text-textBlack pb-5">{{ __('Set your new password') }}</h4>
            </div>
            <form method="POST" action="{{ route('password.update', $token) }}">
                @csrf
                <div class="zForm-wrap zForm-password pb-20">
                    <label for="email" class="zForm-label">{{ __('Email') }}</label>
                    <input type="email" name="email" class="form-control zForm-control" id="email"
                        value="{{ $resetPassword->email }}" placeholder="{{ __('Email') }}" readonly />
                    @error('email')
                        <span class="fs-12 text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="zForm-wrap zForm-password pb-20">
                    <label for="resetPassword" class="zForm-label">{{ __('New Password') }}</label>
                    <input type="password" class="form-control zForm-control" id="resetPassword" name="password"
                        value="{{ old('password') }}" placeholder="{{ __('New Password') }}" />
                    <span class="icon"><img src="{{ asset('user/images/icon/eye.svg') }}" alt="" /></span>
                    @error('password')
                        <span class="fs-12 text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="zForm-wrap zForm-password pb-30">
                    <label for="resetPasswordConfirm" class="zForm-label">{{ __('Confirm Password') }}</label>
                    <input type="password" class="form-control zForm-control" id="resetPasswordConfirm"
                        placeholder="Enter password" name="password_confirmation" />
                    <span class="icon"><img src="{{ asset('user/images/icon/eye.svg') }}" alt="" /></span>
                </div>
                <button type="submit"
                    class="d-flex justify-content-center align-items-center w-100 p-13 border-0 bg-main-color bd-ra-10 fs-16 fw-600 lh-19 text-white mb-13">{{ __('Update') }}</button>
            </form>
        </div>
    </div>
@endsection
