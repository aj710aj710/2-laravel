
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center cg-10 pb-24">
            <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{__("Edit Product")}}</h4>
            <button type="button" class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent" data-bs-dismiss="modal" aria-label="Close"><img src="{{asset('user')}}/images/icon/close.svg" alt="" /></button>
        </div>
        <!-- Body -->
        <form class="ajax" action="{{ route('user.product.store')}}"
              method="POST" enctype="multipart/form-data" data-handler="settingCommonHandler">
            @csrf
            <div class="zForm-wrap pb-20">
                <input type="hidden" value="{{ isset($product->id)?encrypt($product->id):null }}" name="id">
                <label for="eInputProductName" class="zForm-label">{{__("Product Name")}} <span class="text-red">*</span></label>
                <input type="text" class="form-control zForm-control" id="eInputProductName" placeholder="{{__("Enter product name")}}" name="name" value="{{isset($product->name)?$product->name:''}}"/>
            </div>
            <div class="zForm-wrap pb-20">
                <label for="eInputProductDescription" class="zForm-label">{{__("Product Description")}}</label>
                <textarea class="form-control zForm-control h-111" id="eInputProductDescription" placeholder="{{__("Write your thoughts here....")}}" name="description">{{isset($product->description)?$product->description:''}}</textarea>
            </div>

            <div class="zForm-wrap pb-20">
                <label for="eInputPlanPlanStatus" class="zForm-label">{{__("Status")}}</label>
                <div class="d-flex align-items-center flex-wrap g-10">
                    <div
                        class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                        <input class="form-check-input" type="radio" value="1" id="planPlanStatusActive"
                                   name="status" {{isset($product->status) && $product->status == 1?'checked':''}}/>
                        <label class="form-check-label" for="planPlanStatusActive">{{__("Active")}}</label>
                    </div>
                    <div
                        class="zForm-wrap-checkbox py-11 px-16 bd-one bd-c-stroke-color bd-ra-8 bg-input-color">
                        <input class="form-check-input" type="radio" value="0" id="planPlanStatusInactive"
                               name="status" {{isset($product->status) && $product->status == 1?'':'checked'}}/>
                        <label class="form-check-label" for="planPlanStatusInactive">{{__("Inactive")}}</label>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center cg-10">
                <button type="submit" class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">{{__("Submit Now")}}</button>
                <button type="button"
                        class="border-0 bd-ra-12 py-13 px-25 bg-cancel-color fs-16 fw-600 lh-19 text-textBlack" data-bs-dismiss="modal">{{__("Cancel Now")}}</button>
            </div>
        </form>
