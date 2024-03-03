
<!-- Header -->
<div class="d-flex justify-content-between align-items-center cg-10 pb-16">
    <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{__("Update License")}}</h4>
    <button type="button"
            class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
            data-bs-dismiss="modal" aria-label="Close"><img src="{{asset('user')}}/images/icon/close.svg" alt=""/>
    </button>
</div>
<!-- Body -->
<form class="ajax" action="{{ route('user.license.store') }}" method="POST" enctype="multipart/form-data" data-handler="settingCommonHandler">
    @csrf
    <div class="zForm-wrap pb-20">
        <input type="hidden" name="id" value="{{encrypt($license->id)}}">
        <label for="eInputLicenseName" class="zForm-label">{{__("License Name")}}<span
                class="text-red">*</span></label>
        <input type="text" class="form-control zForm-control" id="eInputLicenseName"
               placeholder="{{__("Enter License name")}}" name="name" value="{{$license->name}}"/>
    </div>
    <div class="zForm-wrap pb-20">
        <label for="eInputLicenseCouponCode" class="zForm-label">{{"License Code"}}<span
                class="text-red">*</span></label>
        <input type="text" class="form-control zForm-control" id="eInputLicenseCouponCode"
               placeholder="{{__("Enter License Code")}}" name="code" value="{{$license->code}}"/>
    </div>

    <div class="zForm-wrap pb-20">
        <label for="licenseStatus" class="zForm-label">{{__("License Status")}}<span
                class="text-red">*</span></label>
        <div class="d-flex align-items-center flex-wrap g-10">
            <div
                class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                <input class="form-check-input" type="radio" value="1" id="licenseStatusActive"
                       name="status" {{$license->status == 1?'checked':''}}/>
                <label class="form-check-label" for="licenseStatusActive">{{__("Active")}}</label>
            </div>
            <div
                class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                <input class="form-check-input" type="radio" value="0" id="licenseStatusInactive"
                       name="status" {{$license->status == 0?'checked':''}}/>
                <label class="form-check-label" for="licenseStatusInactive">{{__("Inactive")}}</label>
            </div>
        </div>
    </div>
    <div class="zForm-wrap pb-20">
        <label for="eInputLicenseSelectPlan" class="zForm-label">{{__("Select Plan")}}<span
                class="text-red">*</span></label>
        <select class="sf-select-without-search cs-select-form product-plan" name="product_plan">
            <option value="all Plan">{{__("All Plan")}}</option>
            @if(count($planList) > 0)
                @foreach($planList as $plan)
                    <option value="{{$plan->id}}" {{$license->product_plan == $plan->id?'selected':'' }}>{{$plan->name}}</option>
                @endforeach
            @endif
        </select>
    </div>
    <!-- Buttons -->
    <div class="d-flex align-items-center cg-10 w-100 pt-20">
        <button type="submit" class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">{{__("Save
                            Now")}}
        </button>
        <button type="button" class="border-0 bd-ra-12 py-13 px-25 bg-cancel-color fs-16 fw-600 lh-19 text-textBlack" data-bs-dismiss="modal">
            {{__("Cancel Now")}}
        </button>
    </div>
</form>

