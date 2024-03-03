<div class="min-w-1100 px-20">
    <div class="d-flex justify-content-between align-items-start">
        <div class="d-flex align-items-start cg-47 rg-20 pb-30">
            <!-- Logo -->
            <a href="#" class="max-w-130">
                <img src="{{ $invoiceSettingLogo??'' }}" alt="" /></a>
            <!-- Info -->
            <div class="pl-sm-47 bd-sm-l-one bd-c-stroke-color">
                {!! $invoiceSettingCompanyInfo??'' !!}
            </div>
        </div>
        <button type="button"
            class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
            data-bs-dismiss="modal" aria-label="Close">
            <img src="{{ asset('assets/images/icon/close.svg') }}" alt="" />
        </button>
    </div>
    <!-- ID - Bill - Ship - Payment Method -->
    <div class="d-flex justify-content-between cg-10 pb-30">
        <!-- Id -->
        <div class="flex-shrink-0 max-w-206">
            <h4 class="fs-32 fw-600 lh-40 text-textBlack pb-10">{{ $invoiceSettingTitle??'' }}</h4>
            <p class="fs-14 fw-400 lh-24 text-para-text">{{ __('No') }}
                : {{ $invoiceInfo->invoice_id ?? 'N/A' }}</p>
            <p class="fs-14 fw-400 lh-24 text-para-text">{{ __('Order Date ') }}
                : {{ $invoiceInfo->created_at?->format('Y-m-d') ?? 'N/A' }}</p>
        </div>
        <!-- Billed -->
        <div class="flex-shrink-0 max-w-206">
            {!! $invoiceSettingInfoOne??'' !!}
        </div>
        <!-- Shipped -->
        <div class="flex-shrink-0 max-w-206">
            {!! $invoiceSettingInfoTwo??'' !!}
        </div>

        <!-- Payment Method -->
        <div class="flex-shrink-0 max-w-206">
            {!! $invoiceSettingInfoThree??'' !!}
        </div>
    </div>
    <!-- Table -->
    <table class="table zTable zTable-last-item-right zTable-invoice">
        <thead>
            <tr>
                <th scope="col">
                    <div>{{ __('SL') }}</div>
                </th>
                @if (in_array(TABLE_COLUMN_PRODUCT, $invoiceSettingColumn ?? []))
                    <th scope="col">
                        <div>{{ __('Product') }}</div>
                    </th>
                @endif
                @if (in_array(TABLE_COLUMN_PLAN, $invoiceSettingColumn ?? []))
                    <th scope="col">
                        <div>{{ __('Plan') }}</div>
                    </th>
                @endif
                @if (in_array(TABLE_COLUMN_PRICE, $invoiceSettingColumn ?? []))
                    <th scope="col">
                        <div>{{ __('Price') }}</div>
                    </th>
                @endif
                @if (in_array(TABLE_SETUP_FEE, $invoiceSettingColumn ?? []))
                    <th scope="col">
                        <div>{{ __('SetUp Fee') }}</div>
                    </th>
                @endif
                @if (in_array(TABLE_COLUMN_QUANTITY, $invoiceSettingColumn ?? []))
                    <th scope="col">
                        <div>{{ __('Quantity') }}</div>
                    </th>
                @endif
                @if (in_array(TABLE_COLUMN_TOTAL, $invoiceSettingColumn ?? []))
                    <th scope="col">
                        <div>{{ __('Total') }}</div>
                    </th>
                @endif
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <p>{{ __('1') }}</p>
                </td>
                @if (in_array(TABLE_COLUMN_PRODUCT, $invoiceSettingColumn ?? []))
                    <td>
                        <p class="fw-600 text-textBlack">{{ $invoiceInfo->products_name ?? '' }}</p>
                    </td>
                @endif
                @if (in_array(TABLE_COLUMN_PLAN, $invoiceSettingColumn ?? []))
                    <td>
                        <p>{{ $invoiceInfo->plans_name ?? '' }}</p>
                    </td>
                @endif
                @if (in_array(TABLE_COLUMN_PRICE, $invoiceSettingColumn ?? []))
                    <td>
                        <p>{{ showPrice($invoiceInfo->amount ?? 0)}}</p>
                    </td>
                @endif
                @if (in_array(TABLE_SETUP_FEE, $invoiceSettingColumn ?? []))
                    <td>
                        <p>{{ showPrice($invoiceInfo->setup_fees ?? 0) }}</p>
                    </td>
                @endif
                @if (in_array(TABLE_COLUMN_QUANTITY, $invoiceSettingColumn ?? []))
                    <td>
                        <p>1</p>
                    </td>
                @endif
                @if (in_array(TABLE_COLUMN_TOTAL, $invoiceSettingColumn ?? []))
                    <td>
                        <p>{{ showPrice(($invoiceInfo->amount ?? 0) + ($invoiceInfo->setup_fees ?? 0))}}</p>
                    </td>
                @endif
            </tr>
        </tbody>
    </table>
    <!--  -->
    <div class="mt-18">
        <ul class="max-w-241 ms-auto pr-20">
            <li class="d-flex justify-content-between align-items-center cg-84 text-end">
                <p class="fs-14 fw-500 lh-17 text-para-text">{{ __('Subtotal') }}:</p>
                <p class="fs-14 fw-500 lh-17 text-textBlack">{{showPrice(($invoiceInfo->amount ?? 0) + ($invoiceInfo->setup_fees ?? 0))}}</p>
            </li>
            <li class="d-flex justify-content-between align-items-center cg-84 text-end">
                <p class="fs-14 fw-500 lh-17 text-para-text">{{ __('Discount') }}:</p>
                <p class="fs-14 fw-500 lh-17 text-textBlack">{{ showPrice($invoiceInfo->plan_discount ?? 0) }}</p>
            </li>
            <li class="d-flex justify-content-between align-items-center text-end">
                <p class="fs-14 fw-500 lh-17 text-para-text">{{ __('Shipping Charge') }}:</p>
                <p class="fs-14 fw-500 lh-17 text-textBlack">{{ showPrice($invoiceInfo->order_shipping_cost ?? 0) }}</p>
            </li>
            <li class="d-flex justify-content-between align-items-center text-end">
                <p class="fs-14 fw-500 lh-17 text-para-text">{{ __('Tax') }}:</p>
                <p class="fs-14 fw-500 lh-17 text-textBlack">{{ showPrice($invoiceInfo->order_tax_amount ?? 0) }}</p>
            </li>
            <li class="d-flex justify-content-between align-items-center text-end">
                <p class="fs-14 fw-500 lh-17 text-para-text">{{ __('Total') }}:</p>
                <p class="fs-14 fw-500 lh-17 text-textBlack">{{ showPrice($invoiceInfo->total ?? 0) }}</p>
            </li>
        </ul>
    </div>
    <div class="mb-15 mt-18">
        @if ($invoiceInfo->payment_status == PAYMENT_STATUS_PAID)
            <p>{!! $invoiceSettingFooterText !!}</p>
        @endif
    </div>
    <!-- Buttons -->
    <div class="d-flex g-10">
        <a href="{{ route('user.invoice.download', encrypt($invoiceInfo->id)) }}" target="_blank"
            class="border-0 bd-ra-8 py-13 px-25 bg-green fs-16 fw-600 lh-19 text-white">{{ __('Download') }}</a>
    </div>

</div>
