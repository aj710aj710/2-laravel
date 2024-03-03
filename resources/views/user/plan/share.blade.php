<!-- Header -->
<div class="d-flex justify-content-between align-items-center cg-10 pb-16 mb-18 bd-b-one bd-c-stroke-color">
    <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{__("Share Your Checkout Plan Link")}}</h4>
    <button type="button"
            class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
            data-bs-dismiss="modal" aria-label="Close"><img src="{{asset('user')}}/images/icon/close.svg" alt=""/>
    </button>
</div>
<!-- Body -->
<div class="form-group col-md-12 p-r-0">
    <label class="zForm-label">{{__("Checkout Plan Link")}}<span class="text-danger">*</span></label>
    <div class="d-flex">
        <div class="input-group m-r-10">
            <input type="text" id="inputbox6505525cf8be3267e1a5ff5f" class="form-control zForm-control h-auto" name="copylink"
                   value="{{$checkout_url}}">
            <div class="input-group-append">
                <button class="border-0 bg-transparent p-10 bg-main-color text-white bd-ra-8 copy-subscription-link" data-link="{{$checkout_url}}">{{__("Copy")}}</button>
            </div>
        </div>
    </div>
    <small class="form-text text-muted ws-bs d-block pt-12 mb-13">{{__("Share this checkout page link with your customers to collect the payments
        & manage their subscriptions under Pabbly Subscription Billing.")}}</small>
</div>
<div class="form-group col-md-12 align-middle">
    <div class=""><a href="{{$checkout_url}}"
                     class="bd-one bd-ra-10 d-inline-flex py-11 px-16 bg-main-color text-white mb-15" target="_blank">{{__("Checkout")}}</a></div>
</div>
<div class="form-group col-md-12">
    <label class="zForm-label">{{__("Share on Social Network")}}</label>
    <div class="mb-15 d-flex align-items-center flex-wrap g-10">
        <a href="{{$fb_share}}" class="dl flex-shrink-0 w-30 h-30 d-flex align-items-center justify-content-center bd-one bd-c-stroke-color rounded-circle text-main-color fs-14" target="_blank">
            <i class="fa-brands fa-facebook-f"></i>
        </a>
        <a href="{{$tw_share}}" target="_blank" class="flex-shrink-0 w-30 h-30 d-flex align-items-center justify-content-center bd-one bd-c-stroke-color rounded-circle text-main-color fs-14">
            <i class="fa-brands fa-twitter"></i>
        </a>
    </div>
</div>
<div class="form-group col-md-12">
    <label class="zForm-label">{{__("Embed Plan Link")}}</label>
    <textarea class="showcode form-control zForm-control" id="embed_box_6505525cf8be3267e1a5ff5f" rows="3" name="iframecode">{{$embed_code}}</textarea>
    <small class="form-text text-muted ws-bs d-block pt-12 mb-13">{{__("Use this code to insert the checkout page on your website and start selling")}}
        your items.</small></div>
<div class="form-group col-md-12 align-middle">
    <div class="">
        <button class="border-0 bd-ra-10 d-inline-flex py-11 px-16 bg-main-color text-white share-copy-btn copy-subscription-link" data-link="{{$embed_code}}">{{__("Copy embed code")}}</button>
    </div>
</div>
