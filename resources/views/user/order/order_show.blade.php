<!-- Header -->
<div class="d-flex justify-content-between align-items-center cg-10 pb-16">
    <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{__("Transaction Details")}}</h4>
    <button type="button"
            class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke-color bg-transparent"
            data-bs-dismiss="modal" aria-label="Close"><img src="{{asset('user/images/icon/close.svg')}}" alt=""/>
    </button>
</div>

<hr>
<div class="table-responsive">
    <table class="table bg-light ">
        <thead>
        <tr>
            <th scope="col"><div class="min-w-100">{{__('Date')}}</div></th>
            <th scope="col"><div class="min-w-100">{{__('Gateway')}}</div></th>
            <th scope="col"><div class="min-w-150">{{__('Transaction ID')}}</div></th>
            <th scope="col"><div class="min-w-100">{{__('Amount')}}</div></th>
            <th scope="col"><div class="min-w-100">{{__('Action')}}</div></th>
        </tr>
        </thead>
        <tbody class="table-group-divider ">
        <tr>
            <td>{{date('d-m-Y', strtotime($order->created_at))}}</td>
            <td>{{$order->gateway->title}}</td>
            <td>{{$order->transaction_id ? $order->transaction_id : 'N/A'}}</td>
            <td>{{$order->total}}</td>
            <td>
                @if ($order->payment_status == PAYMENT_STATUS_PAID)
                    <p class='zBadge zBadge-success'>{{__('Paid')}}</p>
                @elseif ($order->payment_status == PAYMENT_STATUS_PENDING)
                    <p class="zBadge zBadge-pending">{{__('Pending')}}</p>
                @elseif ($order->payment_status == PAYMENT_STATUS_CANCELLED)
                    <p class='zBadge zBadge-fuilure'>{{__('Cancel')}}</p>
                @endif
            </td>
        </tr>
        </tbody>
    </table>
</div>
<!-- Body -->
