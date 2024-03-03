<!-- Header -->
<div class="d-flex justify-content-between align-items-center cg-10 pb-16">
    <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{__("Update Plan")}}</h4>
    <button type="button"
            class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
            data-bs-dismiss="modal" aria-label="Close"><img src="{{asset('user')}}/images/icon/close.svg" alt=""/>
    </button>
</div>
<!-- Body -->
<form class="ajax" action="{{ route('user.plan.store') }}"
      method="POST" enctype="multipart/form-data" data-handler="settingCommonHandler">
    @csrf

    <input type="hidden" name="id" value="{{encrypt($plan->id)}}">
    <div class="zForm-wrap pb-20">
        <label for="eInputPlanName" class="zForm-label">{{__("Plan Name")}}<span class="text-red">*</span></label>
        <input type="text" class="form-control zForm-control" id="eInputPlanName"
               placeholder="{{__("Enter Plan name")}}" name="name" value="{{$plan->name??''}}"/>
    </div>
    <div class="zForm-wrap pb-20">
        <label for="eInputPlanCode" class="zForm-label">{{__("Plan Code")}}<span class="text-red">*</span></label>
        <input type="text" class="form-control zForm-control" id="eInputPlanCode"
               placeholder="{{__("Enter Plan Code")}}" name="code" value="{{$plan->code??''}}"/>
    </div>
    <div class="zForm-wrap pb-25">
        <label for="eInputPlanPrice" class="zForm-label">{{__("Plan Price")}}<span
                class="text-red">*</span></label>
        <input type="number" class="form-control zForm-control" id="eInputPlanPrice"
               placeholder="88.00" name="price" value="{{$plan->price??''}}"/>
    </div>
    <div class="zForm-wrap pb-25">
        <label for="eInputPlanPrice" class="zForm-label">{{__("Due Day")}}<span
                class="text-red">*</span></label>
        <input type="text" class="form-control zForm-control" id="eInputPlanPrice"
        value="{{$plan->due_day??''}}" name="due_day"/>
    </div>
    <div class="zForm-wrap pb-25">
        <label for="eInputPlanPrice" class="zForm-label">{{__("Shipping Charge")}}</label>
        <input type="text" class="form-control zForm-control" id="eInputPlanPrice"
               value="{{$plan->shipping_charge??''}}" name="shipping_charge"/>
    </div>
    <div class="zForm-wrap pb-20 bilingCycle-checkbox">
        <label for="eInputPlanBillingCycle" class="zForm-label">{{__("Billing Cycle")}}<span class="text-red">*</span></label>
        <div class="d-flex align-items-center flex-wrap g-10">
            <div class="d-flex align-items-center flex-wrap g-10">
                <div class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color bilingCycle-checkbox-item">
                    <input class="form-check-input" type="radio" value="{{BILLING_CYCLE_ONETIME}}" id="planBillingCycleOneTime" name="billing_cycle" {{$plan->billing_cycle == BILLING_CYCLE_ONETIME?'checked':''}}  />
                    <label class="form-check-label" for="planBillingCycleOneTime">{{__("One Time")}}</label>
                </div>
                <div class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color bilingCycle-checkbox-item">
                    <input class="form-check-input" type="radio" value="{{BILLING_CYCLE_AUTO_RENEW}}" id="planBillingCycleAutoRenew" name="billing_cycle" {{$plan->billing_cycle == BILLING_CYCLE_AUTO_RENEW?'checked':''}}/>
                    <label class="form-check-label" for="planBillingCycleAutoRenew">{{__("Auto renews until cancelled")}}</label>
                </div>
                <div class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color bilingCycle-checkbox-item">
                    <input class="form-check-input" type="radio" value="{{BILLING_CYCLE_EXPIRE_AFTER}}" id="planBillingCycleExpire" name="billing_cycle" {{$plan->billing_cycle == BILLING_CYCLE_EXPIRE_AFTER?'checked':''}}/>
                    <label class="form-check-label" for="planBillingCycleExpire">{{__("Expire after a specified no. of billing cycle")}}</label>
                </div>
            </div>
        </div>
    </div>
    <div class="bilingCycle-open-items">
        <div class="bilingCycle-open-item billing-cycle-item {{$plan->billing_cycle == BILLING_CYCLE_ONETIME?'d-none':''}}">
            <div class="zForm-wrap pb-20 billing-cycle-item-recurring-number {{$plan->billing_cycle == BILLING_CYCLE_EXPIRE_AFTER?'':'d-none'}}">
                <label for="eInputNumberOfRecurringCycle" class="zForm-label">{{__("Number Of Recurring Cycle")}}</label>
                <input type="text" class="form-control zForm-control" id="eInputNumberOfRecurringCycle" placeholder="5" name="number_of_recurring_cycle" value="{{$plan->number_of_recurring_cycle}}"/>
            </div>
            <div class="d-flex cg-10 pb-20">
                <div class="zForm-wrap flex-grow-1">
                    <label for="eInputBill" class="zForm-label">{{__("Bill Every")}}</label>
                    <input type="text" class="form-control zForm-control" id="eInputBill" placeholder="1" name="bill" value="{{$plan->bill}}"/>
                </div>
                <div class="zForm-wrap flex-grow-1 min-w-224">
                    <label for="eInputEvery" class="zForm-label text-white">.</label>
                    <select class="sf-select-without-search cs-select-form" name="duration">
                        <option value="{{DURATION_MONTH}}" {{$plan->duration == DURATION_MONTH?'selected':''}}>{{__("Month")}}</option>
                        <option value="{{DURATION_YEAR}}" {{$plan->duration == DURATION_YEAR?'selected':''}}>{{__("Year")}}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="zForm-wrap pb-20">
        <label for="eInputPlanPlanStatus" class="zForm-label">{{__("Plan Status")}}<span class="text-red">*</span></label>
        <div class="d-flex align-items-center flex-wrap g-10">
            <div
                class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                <input class="form-check-input" type="radio" value="1" id="planPlanStatusActive"
                       name="status" {{$plan->status == 1?'checked':''}}/>
                <label class="form-check-label" for="planPlanStatusActive">{{__("Active")}}</label>
            </div>
            <div
                class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                <input class="form-check-input" type="radio" value="0" id="planPlanStatusInactive"
                       name="status" {{$plan->status == 0?'checked':''}}/>
                <label class="form-check-label" for="planPlanStatusInactive">{{__("Inactive")}}</label>
            </div>
        </div>
    </div>
    <div class="d-flex cg-10 pb-20">
        <div class="zForm-wrap flex-grow-1">
            <label for="eInputFreeTrail" class="zForm-label">{{__("Free Trail")}}</label>
            <input type="text" class="form-control zForm-control" id="eInputFreeTrail"
                   placeholder="10" value="{{$plan->free_trail}}" name="free_trail" {{$plan->free_trail??''}}/>
        </div>
        <div class="zForm-wrap flex-grow-1">
            <label for="eInputSetupFee" class="zForm-label">{{__("Setup Fee")}}</label>
            <input type="text" class="form-control zForm-control" id="eInputSetupFee"
                   placeholder="10" value="{{$plan->setup_fee}}" name="setup_fee" {{$plan->setup_fee??''}}/>
        </div>
    </div>
    <div class="zForm-wrap pb-20">
        <label for="eInputFreeTrail" class="zForm-label">{{__("Details")}}</label>
        <textarea class="form-control zForm-control" id="summernote" cols="30"
                  placeholder="10" name="details">{{$plan->details}}</textarea>
    </div>
    <!-- Buttons -->
    <div class="d-flex align-items-center cg-10">
        <button type="submit" class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">{{__("Save Now")}}
        </button>
        <button type="button"  data-bs-dismiss="modal" aria-label="Close" class="border-0 bd-ra-12 py-13 px-25 bg-cancel-color fs-16 fw-600 lh-19 text-textBlack">
            {{__("Cancel Now")}}
        </button>
    </div>
</form>

