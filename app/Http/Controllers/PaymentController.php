<?php

namespace App\Http\Controllers;

use App\Http\Services\Payment\Payment;
use App\Http\Services\SettingsService;
use App\Models\Gateway;
use App\Models\Invoice;
use App\Models\License;
use App\Models\Order;
use App\Models\Subscription;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    use ResponseTrait;

    public function verify(Request $request)
    {
        $order_id = $request->get('id', '');
        $payerId = $request->get('PayerID', NULL);
        $payment_id = $request->get('payment_id', NULL);

        $order = Order::findOrFail($order_id);
        if ($order->payment_status == PAYMENT_STATUS_PAID) {
            return redirect()->route('thankyou');
        }

        $gateway = Gateway::find($order->gateway_id);
        $settingsService = new SettingsService();
        DB::beginTransaction();
        try {
            if ($order->gateway_id == $gateway->id && $gateway->slug == MERCADOPAGO) {
                $order->payment_id = $payment_id;
                $order->save();
            }

            $subscription = Subscription::find($order->subscription_id);
            $invoice = Invoice::where('subscription_id', $subscription->id)->first();

            $gatewayBasePayment = new Payment($gateway->slug, ['currency' => $order->gateway_currency, 'user_id' => $subscription->user_id]);
            $payment_data = $gatewayBasePayment->paymentConfirmation($order->payment_id, $payerId);
            if ($payment_data['success']) {
                if ($payment_data['data']['payment_status'] == 'success') {
                    // subscription
                    if ($subscription->duration == DURATION_MONTH) {
                        $end_date = now()->addDays(30)->format('Y-m-d');
                    } else {
                        $end_date = now()->addDays(365)->format('Y-m-d');
                    }
                    $licenseData = License::where('product_plan', $subscription->plan_id)->first();
                    if (!is_null($licenseData)) {
                        $subscription->license = $licenseData->code . str_replace('-', '', uuid_create(UUID_TYPE_RANDOM));
                    }
                    $subscription->status = STATUS_ACTIVE;
                    $subscription->end_date = $end_date;
                    $subscription->save();
                    // invoice
                    $invoice->payment_status = PAYMENT_STATUS_PAID;
                    $invoice->save();
                    // order
                    $order->payment_status = PAYMENT_STATUS_PAID;
                    $order->delivery_status = DELIVERY_STATUS_DELIVERED;
                    $order->transaction_id = uniqid();
                    $order->save();

                    DB::commit();

                    //webhook event start
                    $webhookRequestData = [
                        'order_info' => $order,
                        'payment_info' => $payment_data,
                    ];
                    createWebhookEvent(WEBHOOK_EVENT_TYPE_PAYMENT, $subscription->plan_id, $subscription->user_id, $webhookRequestData);
                    //webhook event end

                    //notification call start
                    setCommonNotification('Have a new checkout', 'Order Id: ' . $order->order_id, '', $userId = $subscription->user_id);
                    //notification call end
                    if (getOption('affiliate_status') == STATUS_ACTIVE) {
                        affiliateCommission($invoice);
                    }
                    // send success mail
                    $settingsService->sendPaymentMail($subscription, $invoice, $order, EMAIL_TEMPLATE_PAYMENT_SUCCESS);
                    return redirect()->route('thankyou');
                }
            } else {
                // send failure mail
                $settingsService->sendPaymentMail($subscription, $invoice, $order, EMAIL_TEMPLATE_PAYMENT_FAILURE);
                return redirect()->route('failed');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('failed');
        }
    }

    public function thankyou()
    {
        return view('frontend.thankyou');
    }

    public function waiting()
    {
        return view('frontend.waiting');
    }

    public function failed()
    {
        return view('frontend.failed');
    }
}
