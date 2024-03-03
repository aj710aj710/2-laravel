@extends('affiliate.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="px-24 pb-24 position-relative">
        <!--  -->
        <div class="p-20 bd-one bd-c-stroke-color bd-ra-12 bg-white overflow-hidden">
            <div class="zTab-vertical-wrap">
                <!-- Right -->
                <div class="right">
                    <div class="tab-content" id="myTabContent">
                        <!-- Account Settings -->
                        <div class="tab-pane fade show active" id="accountSettings-tab-pane" role="tabpanel"
                             aria-labelledby="accountSettings-tab" tabindex="0">
                            <form action="{{route('affiliate.profile.profile-update')}}" method="POST" class="ajax reset"
                                  data-handler="commonResponseWithPageLoad">
                                @csrf
                                <h4 class="fs-18 fw-700 lh-24 text-textBlack pb-19 mb-19 bd-b-one bd-c-stroke-color">
                                    {{ __('Personal Information') }}</h4>
                                <!-- Photo -->
                                <div class="pb-30">
                                    <div class="upload-img-box profileImage-upload">
                                        <div class="icon">
                                            <img src="{{ asset('user/images/icon/camera.svg') }}"/>
                                        </div>
                                        <img src="{{getFileUrl($affiliateInfo->image)}}"/>
                                        <input type="file" name="image" id="zImageUpload" accept="image/*"
                                               onchange="previewFile(this)"/>
                                    </div>
                                </div>
                                <!-- Inputs -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="zForm-wrap pb-20">
                                            <label for="name" class="zForm-label">{{ __('Name') }}</label>
                                            <input type="text" name="name" class="form-control zForm-control"
                                                   id="name" value="{{$affiliateInfo->name}}"
                                                   placeholder="{{ __('Name') }}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="zForm-wrap pb-20">
                                            <label for="email" class="zForm-label">{{ __('Email') }}</label>
                                            <input type="email" name="email" class="form-control zForm-control"
                                                   id="email" value="{{$affiliateInfo->email}}"
                                                   placeholder="{{ __('Email') }}" readonly/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="zForm-wrap pb-20">
                                            <label for="mobile" class="zForm-label">{{ __('Phone') }}</label>
                                            <input type="text" name="mobile" class="form-control zForm-control"
                                                   id="mobile" value="{{$affiliateInfo->mobile}}"
                                                   placeholder="{{ __('Phone') }}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="zForm-wrap pb-20">
                                            <label for="mobile" class="zForm-label">{{ __('Address') }}</label>
                                            <input type="text" name="address" class="form-control zForm-control"
                                                   id="address" value="{{$affiliateInfo->address}}"
                                                   placeholder="{{ __('Inter address') }}"/>
                                        </div>
                                    </div>
                                    <h4 class="fs-18 fw-700 lh-24 text-textBlack pb-19 mb-19 bd-b-one bd-c-stroke-color">
                                        {{ __('Change Password') }}
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="zForm-wrap pb-20">
                                                <label class="zForm-label">{{ __('Old Password') }}</label>
                                                <input type="password" name="old_password" class="form-control zForm-control"  value=""
                                                       placeholder="{{ __('Enter new Password') }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="zForm-wrap pb-20">
                                                <label class="zForm-label">{{ __('New Password') }}</label>
                                                <input type="password" name="password" class="form-control zForm-control"
                                                       value="" placeholder="{{ __('New Password') }}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center cg-10">
                                        <button
                                            class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">{{ __('Update') }}</button>
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
