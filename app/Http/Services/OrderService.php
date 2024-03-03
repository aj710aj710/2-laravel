<?php

namespace App\Http\Services;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class OrderService
{
    use ResponseTrait;

    public function customerAll()
    {
        return User::where('role', USER_ROLE_CUSTOMER)->count('id');
    }

    public function productAll()
    {
        return Product::count('id');
    }

    public function subscriptionAll()
    {
        return Subscription::count('id');
    }

    public function orderAmount()
    {
        return Order::sum('amount');
    }

    public function orderList()
    {
        $order = Order::leftJoin('plans', 'orders.plan_id', '=', 'plans.id')
            ->leftJoin('gateways', 'orders.gateway_id', '=', 'gateways.id')
            ->leftJoin('users', 'orders.customer_id', '=', 'users.id')
            ->leftJoin('subscriptions', 'orders.subscription_id', '=', 'subscriptions.id')
            ->leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->leftJoin('invoices', 'orders.invoice_id', '=', 'invoices.id')
            ->where('orders.user_id', auth()->id())
            ->where('orders.payment_status', PAYMENT_STATUS_PAID)
            ->select(
                'users.email',
                'orders.created_at',
                'orders.id',
                'orders.total as amount',
                'plans.name as plan_name',
                'gateways.title as gateway_name',
                'products.name as product_name',
                'invoices.invoice_id as invoiceId',
                'subscriptions.subscription_id as subscriptionId',
            )->orderBy('orders.id', 'desc');

        return datatables($order)
            ->addIndexColumn()
            ->addColumn('planName', function ($data) {
                return $data->plan_name;
            })
            ->addColumn('created_at', function ($data) {
                return $data->created_at?->format('Y-m-d');
            })
            ->addColumn('amount', function ($data) {
                return showPrice($data->amount);
            })
            ->addColumn('gateway', function ($data) {
                return $data->gateway_name;
            })
            ->addColumn('customer', function ($data) {
                return $data->email;
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
            ->rawColumns(['created_at', 'amount'])
            ->make(true);
    }

    public function allOrder($request)
    {
        $status = 0;
        if ($request->status == 'paid') {
            $status = PAYMENT_STATUS_PAID;
        } else if ($request->status == 'pending') {
            $status = PAYMENT_STATUS_PENDING;
        } else if ($request->status == 'bank') {
            $status = PAYMENT_STATUS_PENDING;
        } else if ($request->status == 'cancelled') {
            $status = PAYMENT_STATUS_CANCELLED;
        }

        $orders = Order::query()
            ->leftJoin('gateways', 'orders.gateway_id', '=', 'gateways.id')
            ->leftJoin('users', 'orders.customer_id', '=', 'users.id')
            ->leftJoin('file_managers', ['orders.bank_deposit_slip_id' => 'file_managers.id'])
            ->leftJoin('plans', 'orders.plan_id', '=', 'plans.id')
            ->leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->select([
                'orders.created_at',
                'orders.id',
                'orders.payment_status',
                'users.email',
                'users.name',
                'orders.total',
                'gateways.slug as gatewaySlug',
                'orders.id as order_id',
                'products.name as product_name',
                'gateways.title as gateway_name',
                'plans.name as plan_name',
                'file_managers.id as file_id',
            ])
            ->orderBy('orders.id', 'desc');

        if ($request->status == 'bank') {
            $orders->whereNotNull('orders.bank_deposit_slip_id');
        }
        if ($request->status == 'all') {
            $orders = $orders->where('orders.user_id', auth()->id());
        } else {
            $orders = $orders->where('orders.payment_status', $status)
                ->where('orders.user_id', auth()->id());
        }

        return datatables($orders)
            ->addIndexColumn()
            ->addColumn('status', function ($data) {
                if ($data->payment_status == PAYMENT_STATUS_PAID) {
                    return "<p class='zBadge zBadge-success'>Paid</p>";
                } elseif ($data->payment_status == PAYMENT_STATUS_PENDING) {
                    return "<p class='zBadge zBadge-pending'>Pending</p>";
                } else {
                    return "<p class='zBadge zBadge-fuilure'>Cancel</p>";
                }
            })
            ->addColumn('planName', function ($data) {
                return $data->plan_name;
            })
            ->addColumn('created_at', function ($data) {
                return date('d-m-Y', strtotime($data->created_at));
            })
            ->addColumn('amount', function ($data) {
                return showPrice($data->total);
            })
            ->addColumn('gateway', function ($data) {
                return $data->gateway_name;
            })
            ->addColumn('customer_name', function ($data) {
                return $data->name;
            })
            ->addColumn('customer', function ($data) {
                return $data->email;
            })
            ->addColumn('productName', function ($data) {
                return $data->product_name;
            })
            ->addColumn('action', function ($data) {
                $html = '<div class="d-flex justify-content-end align-items-center g-10">';
                $html = "<button class='border-0 p-0 bg-transparent flex-shrink-0 me-2' onclick='getEditModal(\"" . route("user.orders.payment.show", $data->order_id) . "\"" . ", \"#showPaymentModal\")'><img src='" . asset('user/images/icon/eye.svg') . "' alt=''></button>";
                if ($data->payment_status == PAYMENT_STATUS_PENDING) {
                    $html .= "<button type='button' class='border-0 p-0 bg-transparent flex-shrink-0 me-2' onclick='getEditModal(\"" . route("user.orders.payment.edit", $data->order_id) . "\"" . ", \"#edit-modal\")' title='Edit'><img src='" . asset('user/images/icon/edit.svg') . "' alt=''></button>";
                }

                if ($data->gatewaySlug == PAYMENT_STATUS_BANK) {
                    $html .= '<a href="' . getFileUrl($data->file_id) . '"  class=" border-0 p-0 bg-transparent flex-shrink-0" title="Bank slip download" download><img src="' . asset("user/images/icon/download.svg") . '" alt="download"></a>';
                }
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['created_at', 'total_amount', 'status', 'action'])
            ->make(true);
    }

    public function getOrder($id)
    {
        try {
            $data['order'] = Order::with('gateway')->find($id);
            if (is_null($data['order'])) {
                return $this->error([], getMessage(SOMETHING_WENT_WRONG));
            }
            return $data['order'];
        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function paymentStatusUpdate($request)
    {
        try {
            DB::beginTransaction();
            $id = $request->get('id', 0);

            $status = in_array($request->payment_status, [PAYMENT_STATUS_PENDING, PAYMENT_STATUS_PAID, PAYMENT_STATUS_CANCELLED, PAYMENT_STATUS_BANK]) ? $request->payment_status : PAYMENT_STATUS_PENDING;
            $order = Order::where('user_id', auth()->id())->findOrFail($id);
            $subscription = Subscription::find($order->subscription_id);
            $invoice = Invoice::where('subscription_id', $subscription->id)->first();

            $order->update([
                'payment_status' => $status
            ]);

            $subsDataArray = [];
            if ($status == PAYMENT_STATUS_PAID) {
                if ($order->duration_type == DURATION_MONTH) {
                    $end_date = now()->addDays(30)->format('Y-m-d');
                } else {
                    $end_date = now()->addDays(365)->format('Y-m-d');
                }
                $subsDataArray = [
                    'status' => $status,
                    'end_date' => $end_date
                ];

                //notification call start
                setCommonNotification('Have a new checkout', 'Order Id: ' . $order->order_id, '', $userId = $order->user_id);
                //notification call end
                if (getOption('affiliate_status') == STATUS_ACTIVE) {
                    affiliateCommission($invoice);
                }
            } else if ($status == PAYMENT_STATUS_CANCELLED) {
                $subsDataArray = [
                    'status' => $status
                ];
            }

            Subscription::where('id', $order->subscription_id)
                ->update($subsDataArray);

            $invoice = Invoice::find($order->invoice_id);
            $invoice->payment_status = $status;
            $invoice->save();

            DB::commit();

            //webhook event start
            $webhookRequestData = [
                'order_info' => $order,
            ];
            createWebhookEvent(WEBHOOK_EVENT_TYPE_PAYMENT, $order->plan_id, $order->user_id, $webhookRequestData);
            //webhook event end

            // email send
            if ($status == PAYMENT_STATUS_PAID) {
                $templateCategory = EMAIL_TEMPLATE_PAYMENT_SUCCESS;
            } elseif ($status == PAYMENT_STATUS_PENDING) {
                $templateCategory = EMAIL_TEMPLATE_PAYMENT_FAILURE;
            } else {
                $templateCategory = EMAIL_TEMPLATE_PAYMENT_CANCEL;
            }

            $settingsService = new SettingsService();
            $settingsService->sendPaymentMail($subscription, $invoice, $order, $templateCategory);

            return $this->success([], getMessage(__(STATUS_UPDATED_SUCCESSFULLY)));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(__(SOMETHING_WENT_WRONG)));
        }
    }
}
