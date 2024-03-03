<!-- Header -->
<div class="d-flex justify-content-between align-items-center cg-10 pb-16">
    <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{__("Update Webhook")}}</h4>
    <button type="button"
            class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
            data-bs-dismiss="modal" aria-label="Close"><img src="{{asset('user')}}/images/icon/close.svg" alt=""/>
    </button>
</div>
<!-- Body -->
<form class="ajax" action="{{ route('user.webhook.store') }}"
      method="POST" data-handler="commonResponse">
    @csrf
    <div class="col-12 pb-25">
        <input type="hidden" value="{{$webhook->id}}" name="id">
        <div class="zForm-wrap">
            <label for="invoiceTotalProductAmount" class="zForm-label">{{__('Webhook Name')}}</label>
            <input type="text" name="webhook_name" class="form-control zForm-control" placeholder="{{__('Webhook Name')}}"  value="{{$webhook->webhook_name}}"/>
        </div>
    </div>
    <div class="col-12">
        <div class="zForm-wrap pb-20">
            <label class="zForm-label">{{ __('Select Product') }}</label>
            <select class="sf-select-without-search cs-select-form product-change-action" name="product_id">
                <option>{{__('Select Product')}}</option>
                @foreach ($allProducts as $product)
                    <option value="{{ $product->id }}" {{$product->id == $webhook->product_id?'selected':''}}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12">
        <div class="zForm-wrap pb-20">
            <label class="zForm-label">{{ __('Select Plan') }}</label>
            <select class="sf-select-without-search plan-filter-data-for-webhook" name="plan_id">
                <option value="">{{__('Select Plan')}}</option>
                @foreach($planList as $plan)
                    <option value="{{$plan->id}}" {{$plan->id == $webhook->plan_id?'selected':''}}>{{$plan->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 pb-25">
        <div class="zForm-wrap">
            <label for="invoiceTotalProductAmount" class="zForm-label">{{__('Webhook URL')}}</label>
            <input type="text" name="webhook_url" class="form-control zForm-control" placeholder="" value="{{$webhook->webhook_url}}"/>
        </div>
    </div>
    <button type="submit" class="border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">{{__('Save Now')}}</button>
</form>
