<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use App\Http\Services\OrderService;

class OrderController extends Controller
{
    use ResponseTrait;

    public $orderService;
    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = __('Orders');
        $data['activeOrderList'] = 'active';

        if ($request->ajax()) {
            return $this->orderService->allOrder($request);
        }
        return view('user.order.index', $data);
    }

    public function sales(Request $request)
    {
        $data['pageTitle'] = __('Sales');
        $data['activeSalesList'] = 'active';
        $data['customerAll'] = $this->orderService->customerAll();
        $data['productAll'] = $this->orderService->productAll();
        $data['subscriptionAll'] = $this->orderService->subscriptionAll();
        $data['orderAmount'] = $this->orderService->orderAmount();

        if ($request->ajax()) {
            return $this->orderService->orderList();
        }
        return view('user.order.sales', $data);
    }

    public function paymentShow($id)
    {
        $data['order'] =  $this->orderService->getOrder($id);
        return view('user.order.order_show', $data);
    }

    public function paymentEdit($id)
    {
        $data['order'] =  $this->orderService->getOrder($id);
        return view('user.order.order_payment_edit', $data);
    }

    public function paymentUpdate(Request $request)
    {
        return $this->orderService->paymentStatusUpdate($request);
    }
}
