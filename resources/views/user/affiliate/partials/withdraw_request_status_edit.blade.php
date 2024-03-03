<div class="d-flex justify-content-between align-items-center cg-10 pb-16">
    <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{ __('Withdraw Request Status Change') }}</h4>
    <button type="button"
        class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
        data-bs-dismiss="modal" aria-label="Close"><img src="{{ asset('user/images/icon/close.svg') }}" alt="" />
    </button>
</div>
<hr>
<form class="ajax reset" action="{{ route('user.affiliate.withdraw.request.status.change') }}" method="POST"
    data-handler="settingCommonHandler">
    @csrf
    <input type="hidden" value="{{ $withdraw->id }}" name="id">
    <div class="col-12 ">
        <div class="zForm-wrap ">
            <label class="zForm-label">{{ __('Status') }}</label>
            <select class="sf-select-without-search cs-select-form" id="product-id" name="status">
                <option {{ $withdraw->status == STATUS_ACTIVE ? 'selected' : '' }} value="{{ STATUS_ACTIVE }}">
                    {{ __('Paid') }}</option>
                <option {{ $withdraw->status == STATUS_CANCELED ? 'selected' : '' }} value="{{ STATUS_CANCELED }}">
                    {{ __('Reject') }}</option>
            </select>
        </div>
    </div>

    <button type="submit"
        class="mt-4 border-0 bd-ra-12 py-13 px-25 bg-main-color fs-16 fw-600 lh-19 text-white">{{ __('Update') }}</button>
</form>
