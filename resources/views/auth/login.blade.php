@extends('auth.layouts.app')

@push('title')
    {{ __('Login') }}
@endpush
@section('content')
    <div class="zMain-signLog">
        <div class="zMain-signLog-wrap">
            <div class="pb-34">
                <a href="{{ route('frontend') }}" class="max-w-163"><img src="{{ getSettingImage('app_logo') }}"
                        alt="{{ getOption('app_name') }}" /></a>
            </div>
            <div class="pb-30">
                <h4 class="fs-32 fw-600 lh-40 text-textBlack pb-5">{{ __('Sign In') }}</h4>
                @if (isAddonInstalled('SUBSAAS') > 0)
                    @if (getOption('registration_status', 0) == ACTIVE)
                        <h6 class="fs-14 fw-500 lh-24 text-para-text">{{ __('Don’t have an account') }}? <a
                                href="{{ route('user.register.form') }}" class="text-main-color">{{ __('Sign Up') }}</a>
                        </h6>
                    @endif
                @endif
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="zForm-wrap">
                    <label for="eInputEmailAddress" class="zForm-label">{{ __('Email') }}</label>
                    <input type="email" name="email" class="form-control zForm-control" id="eInputEmailAddress"
                        placeholder="{{ __('Enter email address') }}" />
                </div>
                @error('email')
                    <span class="fs-12 text-danger">{{ $message }}</span>
                @enderror
                <div class="zForm-wrap zForm-password mt-3">
                    <label for="signInPassword" class="zForm-label">{{ __('Password') }}</label>
                    <input type="password" name="password" class="form-control zForm-control" id="signInPassword"
                        placeholder="{{ __('Enter password') }}" />
                    <span class="icon"><img src="{{ asset('user/images/icon/eye.svg') }}" alt="" /></span>
                </div>
                @error('password')
                    <span class="fs-12 text-danger">{{ $message }}</span>
                @enderror
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="zForm-wrap-checkbox">
                        <input class="form-check-input" type="checkbox" id="rememberMe" name="remember" value="1" />
                        <label class="form-check-label" for="rememberMe">{{ __('Remember me') }}</label>
                    </div>
                    <a href="{{ route('password.request') }}"
                        class="fs-14 fw-500 lh-24 text-main-color">{{ __('Forgot Password?') }}</a>
                </div>
                @if (!empty(getOption('google_recaptcha_status')) && getOption('google_recaptcha_status') == 1)
                    <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                        <div class="col-md-6">
                            {!! RecaptchaV3::field('register') !!}
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
                <button type="submit"
                    class="align-items-center bd-ra-10 bg-main-color border-0 d-flex fs-16 fw-600 justify-content-center lh-19 mb-13 mt-2 p-13 text-white w-100">{{ __('Sign In') }}</button>
            </form>

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
            @if (env('LOGIN_HELP') == 'active')
                <div class="row">
                    <div class="col-md-12 mb-25">
                        <div class="table-responsive login-info-table mt-3">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td colspan="2" id="adminCredentialShow" class="login-info">
                                            <b>{{ __('Admin ') }}:</b> {{ __('admin@gmail.com') }} | 123456 <span
                                                class="badge bg-danger">Addon</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" id="userCredentialShow" class="login-info">
                                            <b>{{ __('User') }} :</b> {{ __('user@gmail.com') }} | 123456
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" id="affiliateCredentialShow" class="login-info">
                                            <b>{{ __('Affiliator') }} :</b> {{ __('affiliate@gmail.com') }} | 123456
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('script')
    <script>
        "use strict"
        $('#adminCredentialShow').on('click', function() {
            $('#eInputEmailAddress').val('admin@gmail.com');
            $('#signInPassword').val('123456');
        });
        $('#userCredentialShow').on('click', function() {
            $('#eInputEmailAddress').val('user@gmail.com');
            $('#signInPassword').val('123456');
        });
        $('#affiliateCredentialShow').on('click', function() {
            $('#eInputEmailAddress').val('affiliate@gmail.com');
            $('#signInPassword').val('123456');
        });
    </script>
@endpush
