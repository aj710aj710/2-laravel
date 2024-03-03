@extends('auth.layouts.app')

@push('title')
    {{ __('Registration') }}
@endpush

@section('content')
    <div class="zMain-signLog">
        <div class="zMain-signLog-wrap">
            <div class="pb-34">
                <a href="{{ route('frontend') }}" class="max-w-163"><img src="{{ getSettingImage('app_logo') }}"
                        alt="{{ getOption('app_name') }}" /></a>
            </div>
            <div class="pb-30">
                <h4 class="fs-32 fw-600 lh-40 text-textBlack pb-5">{{ __('Sign up') }}</h4>
                <h6 class="fs-14 fw-500 lh-24 text-para-text">{{ __('Already have an account') }}? <a
                        href="{{ route('login') }}" class="text-main-color">{{ __('Sign In') }}</a></h6>
            </div>
            <form action="{{ route('user.register.store') }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="zForm-wrap pb-20">
                    <label for="eInputFullName" class="zForm-label">{{ __('Name') }} <span class="text-danger">
                            *</span></label>
                    <input type="text" class="form-control zForm-control" id="eInputFullName"
                        value="{{ old('name') }}" name="name" placeholder="{{ __('Name') }}" />
                    @error('name')
                        <span class="fs-12 text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="zForm-wrap pb-20">
                    <label for="eInputPhone" class="zForm-label">{{ __('Phone') }}</label>
                    <input type="text" class="form-control zForm-control" id="eInputPhone" value="{{ old('mobile') }}"
                        name="mobile" placeholder="{{ __('Phone') }}" />
                    @error('name')
                        <span class="fs-12 text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="zForm-wrap pb-20">
                    <label for="eInputEmailAddress" class="zForm-label">{{ __('Email') }}</label>
                    <input type="email" class="form-control zForm-control" id="eInputEmailAddress"
                        value="{{ old('email') }}" name="email" placeholder="Enter email address" />
                    @error('email')
                        <span class="fs-12 text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="zForm-wrap zForm-password pb-30">
                    <label for="signInPassword" class="zForm-label">{{ __('Password') }}</label>
                    <input type="password" class="form-control zForm-control" id="signInPassword" name="password"
                        placeholder="Enter password" />
                    <span class="icon"><img src="{{ asset('user/images/icon/eye.svg') }}" alt="" /></span>
                    @error('password')
                        <span class="fs-12 text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="zForm-wrap zForm-password pb-30">
                    <label for="signInConfirmPassword" class="zForm-label">{{ __('Confirm Password') }}</label>
                    <input type="password" class="form-control zForm-control" id="signInConfirmPassword"
                        name="password_confirmation" placeholder="Enter password" />
                    <span class="icon"><img src="{{ asset('user/images/icon/eye.svg') }}" alt="" /></span>
                </div>
                <button type="submit"
                    class="d-flex justify-content-center align-items-center w-100 p-13 border-0 bg-main-color bd-ra-10 fs-16 fw-600 lh-19 text-white mb-13">{{ __('Sign Up') }}</button>

                <!-- Another Sign In options -->
                @if (getOption('google_login_status') == 1 || getOption('facebook_login_status') == 1)
                    <h4 class="position-relative fs-14 fw-400 lh-24 text-para-text text-center mb-20 under-border-one"><span
                            class="bg-white position-relative px-10">{{ __('Or continue with') }}</span></h4>

                    <ul class="d-flex justify-content-center align-items-center g-10">
                        @if (getOption('facebook_login_status') == 1)
                            <li>
                                <a href="{{ route('facebook-login') }}"
                                    class="w-56 h-56 rounded-circle bd-one bd-c-stroke-color d-flex justify-content-center align-items-center bg-transparent">
                                    <img src="{{ asset('user/images/icon/facebook.svg') }}" alt="{{ __('facebook') }}" />
                                </a>
                            </li>
                        @endif
                        @if (getOption('google_login_status') == 1)
                            <li>
                                <a href="{{ route('google-login') }}"
                                    class="w-56 h-56 rounded-circle bd-one bd-c-stroke-color d-flex justify-content-center align-items-center bg-transparent">
                                    <img src="{{ asset('user/images/icon/google.svg') }}" alt="{{ __('google') }}" />
                                </a>
                            </li>
                        @endif
                    </ul>
                @endif
            </form>
        </div>
    </div>
@endsection
