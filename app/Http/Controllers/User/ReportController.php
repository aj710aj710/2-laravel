<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    use ResponseTrait;

    public function productList(Request $request)
    {
        if ($request->ajax()) {
            $product = Product::where('user_id', auth()->id());
            return datatables($product)
                ->addColumn('total_plans', function ($data) {
                    return count($data->plans);
                })
                ->addColumn('total_coupons', function ($data) {
                    return count($data->coupons);
                })
                ->addColumn('total_license', function ($data) {
                    return count($data->coupons);
                })
                ->addColumn('created_at', function ($data) {
                    return date('d/m/Y', strtotime($data->created_at));
                })
                ->rawColumns(['created_at'])
                ->make(true);
        }
        $data['showReportActive'] = 'show active';
        $data['pageTitle'] = __('All Products List');
        $data['activeReportList'] = 'active';
        return view('user.report.product-list', $data);
    }

    public function salesList(Request $request)
    {
        if ($request->ajax()) {
            $order = Order::join('plans', 'orders.plan_id', '=', 'plans.id')
                ->join('gateways', 'orders.gateway_id', '=', 'gateways.id')
                ->join('users', 'orders.customer_id', '=', 'users.id')
                ->join('products', 'orders.product_id', '=', 'products.id')
                ->join('invoices', 'orders.invoice_id', '=', 'invoices.id')
                ->join('subscriptions', 'orders.subscription_id', '=', 'subscriptions.id')
                ->select('orders.created_at as order_date', 'users.email as customer_email', 'orders.total', 'orders.tax_amount', 'products.name as product_name', 'gateways.title as gateway_name', 'orders.amount', 'subscriptions.subscription_id as subscriptionId', 'plans.name as plan_name', 'invoices.invoice_id as invoiceId')->get();

            return datatables($order)
                ->addIndexColumn()
                ->addColumn('planName', function ($data) {
                    return $data->plan_name;
                })
                ->addColumn('created_at', function ($data) {
                    return date('d/m/Y', strtotime($data->order_date));
                })
                ->addColumn('tax', function ($data) {
                    return showPrice($data->tax_amount);
                })
                ->addColumn('total', function ($data) {
                    return showPrice($data->total);
                })
                ->addColumn('gateway', function ($data) {
                    return $data->gateway_name;
                })
                ->addColumn('customer', function ($data) {
                    return $data->customer_email;
                })
                ->addColumn('productName', function ($data) {
                    return $data->product_name;
                })
                ->addColumn('invoice', function ($data) {
                    return $data->invoiceId;
                })
                ->addColumn('subscription', function ($data) {
                    return $data->subscriptionId;
                })
                ->rawColumns([])
                ->make(true);
        }
        $data['showReportActive'] = 'show active';
        $data['pageTitle'] = __('All Sales List');
        $data['activeSalesList'] = 'active';
        return view('user.report.sales-list', $data);
    }

    public function customerList(Request $request)
    {
        if ($request->ajax()) {
            $user = User::leftJoin('orders', 'users.id', '=', 'orders.customer_id')
                ->leftJoin('gateways', 'orders.gateway_id', '=', 'gateways.id')
                ->leftJoin('user_details', 'users.id', '=', 'user_details.user_id')
                ->select(
                    'users.name as customer_name',
                    'gateways.title as gateway_name',
                    'users.email as customer_email',
                    'user_details.billing_country',
                    'users.created_at as customer_create_date',
                    'users.country as user_country',
                    DB::raw('SUM(orders.total) as total_revenue'),
                    DB::raw('SUM(orders.tax_amount) as total_tax'),
                    'users.id as customer_id'
                )
                ->where('orders.user_id', auth()->id())
                ->where('orders.payment_status', PAYMENT_STATUS_PAID)
                ->groupBy('users.id');

            return datatables($user)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    return '<h4 class="fs-14 fw-400 lh-24 text-para-text">' . htmlspecialchars($data->customer_name) . ' </h4>';
                })
                ->addColumn('email', function ($data) {
                    return $data->customer_email ?? __("N/A");
                })
                ->addColumn('created_at', function ($data) {
                    return date('d-m-Y', strtotime($data->customer_create_date));
                })
                ->addColumn('revenue', function ($data) {
                    return showPrice($data->total_revenue);
                })
                ->addColumn('tax', function ($data) {
                    return showPrice($data->total_tax);
                })
                ->addColumn('country', function ($data) {
                    return $data->billing_country ?? __("N/A");
                })
                ->addColumn('payment', function ($data) {
                    return $data->gateway_name ?? __("N/A");
                })
                ->rawColumns(['name'])
                ->make(true);
        }
        $data['showReportActive'] = 'show active';
        $data['pageTitle'] = __('All Customers List');
        $data['activeCustomerList'] = 'active';
        return view('user.report.customer-list', $data);
    }
}
