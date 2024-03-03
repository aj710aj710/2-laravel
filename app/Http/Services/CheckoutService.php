<?php

namespace App\Http\Services;

use App\Http\Services\Payment\Payment;
use App\Models\Bank;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\FileManager;
use App\Models\Gateway;
use App\Models\GatewayCurrency;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\TaxSetting;
use App\Models\User;
use App\Models\UserDetails;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CheckoutService
{
    use ResponseTrait;

    public function getCurrencyByGatewayId($id)
    {
        $currencies = GatewayCurrency::where(['gateway_id' => $id])->get();
        foreach ($currencies as $currency) {
            $currency->symbol =  $currency->symbol;
        }
        return $currencies?->makeHidden(['created_at', 'updated_at', 'deleted_at', 'gateway_id']);
    }

    public function checkoutOrder($request)
    {
        DB::beginTransaction();
        try {
            if (is_null($request->gateway) || is_null($request->currency)) {
                throw new Exception(__('Please select gateway or currency'));
            }
            $checkout_details = decrypt($request->checkout_details);
            $userId = $checkout_details['user_id'];
            $planId = $checkout_details['plan_id'];
            $plan =  Plan::where('user_id', $userId)->findOrFail($planId);
            $gateway = Gateway::where(['user_id' => $userId, 'slug' => $request->gateway, 'status' => ACTIVE])->firstOrFail();
            $gatewayCurrency = GatewayCurrency::where(['user_id' => $userId, 'gateway_id' => $gateway->id, 'currency' => $request->currency])->firstOrFail();
            $data['gateway'] = $request->gateway;

            // affiliate commission
            $affiliateCode = null;
            if (getOption('affiliate_status') == STATUS_ACTIVE) {
                if (isset($checkout_details['affiliate_code'])) {
                    $affiliateUser = User::query()
                        ->where('created_by', $checkout_details['user_id'])
                        ->where('affiliate_code', $checkout_details['affiliate_code'])
                        ->where('role', USER_ROLE_AFFILIATE)
                        ->where('status', STATUS_ACTIVE)
                        ->first();

                    if (!is_null($affiliateUser)) {
                        $affiliateCode = $affiliateUser->affiliate_code;
                    }
                }
            }

            $coupon = Coupon::query()
                ->where('user_id', $userId)
                ->where('code', $request->coupon_code)
                ->where('product_plan', $planId)
                ->where('status', STATUS_ACTIVE)
                ->select('discount_type', 'discount', 'valid_date')
                ->first();

            if (!getUserPackageLimit(RULES_CUSTOMER, $userId) > 0) {
                $adminUser = User::where('role', USER_ROLE_ADMIN)->first();
                setCommonNotification('Customer Limit Over', 'Customer Limit Over', '', $adminUser->id);
                throw new Exception(__('Checkout is not complete! Please contact with admin aa'));
            }

            if (!getUserPackageLimit(RULES_SUBSCRIPTION, $userId) > 0) {
                $adminUser = User::where('role', USER_ROLE_ADMIN)->first();
                setCommonNotification('Subscription Limit Over', 'Subscription Limit Over', '', $adminUser->id);
                throw new Exception(__('Checkout is not complete! Please contact with admin bb'));
            }

            $user = User::where('email', $request->basic_email)->first();
            if (is_null($user)) {
                $user =  new User();
                $user->name = $request->basic_first_name . ' ' . $request->basic_last_name;
                $user->created_by = $plan->user_id;
                $user->mobile = $request->basic_phone;
                $user->company_name = $request->basic_company;
                $user->email = $request->basic_email;
                $user->password = Hash::make(rand(111111, 999999));
                $user->role = USER_ROLE_CUSTOMER;
                $user->save();
            }

            $this->userDetailsUpdate(
                $user->id,
                $request->basic_first_name,
                $request->basic_last_name,
                $request->basic_email,
                $request->basic_phone,
                $request->basic_company,
                $request->billing_address,
                $request->billing_zip_code,
                $request->billing_city,
                $request->billing_state,
                $request->billing_country,
                $request->shipping_address,
                $request->shipping_address,
                $request->shipping_method,
                $request->shipping_city,
                $request->shipping_state,
                $request->shipping_country,
                $request->basic_info,
                $request->billing_info,
                $request->shipping_info,
            );
            //TODO: put extra field here
            $subscription = new Subscription();
            $subscription->product_id = $plan->product_id;
            $subscription->plan_id = $plan->id;
            $subscription->subscription_id = uniqid();
            $subscription->affiliate_code = $affiliateCode;
            $subscription->user_id = $plan->user_id;
            $subscription->customer_id = $user->id;
            $subscription->due_day = $plan->due_day;
            $subscription->amount = $plan->price;
            $subscription->status = STATUS_PENDING;
            $subscription->free_trail = $plan->free_trail;
            $subscription->setup_fee = $plan->setup_fee ?? 0;
            $subscription->shipping_charge = $plan->shipping_charge;
            $subscription->billing_cycle = $plan->billing_cycle;
            $subscription->bill = $plan->bill;
            $subscription->duration = $plan->duration;
            $subscription->start_date = date('Y-m-d');
            $subscription->number_of_recurring_cycle = $plan->number_of_recurring_cycle;
            $subscription->save();

            $invoiceService = new InvoiceService();
            $recurringStatus = in_array($subscription->billing_cycle, [BILLING_CYCLE_AUTO_RENEW, BILLING_CYCLE_EXPIRE_AFTER]) ? 1 : 0;
            $invoice = $invoiceService->makeInvoice($recurringStatus, $subscription->id);

            $tax = 0;
            $price = $subscription->amount;
            $couponId = null;
            $couponCode = null;
            $couponDiscount = 0;
            $couponDiscountType = DISCOUNT_TYPE_FLAT;
            if (!is_null($coupon)) {
                if ($coupon->valid_date >= date('Y-m-d')) {
                    $couponId = $coupon->id;
                    $couponCode = $coupon->code;
                    $invoiceCoupons =  Invoice::where('user_id', $userId)->where('customer_id', $user->id)->where('coupon_id', $coupon->id)->get();
                    if ($coupon->discount_type == DISCOUNT_TYPE_FLAT) {
                        $couponDiscount = $coupon->discount;
                    } else {
                        $couponDiscount = $price * $coupon->discount * 0.01;
                        $couponDiscountType = DISCOUNT_TYPE_PERCENT;
                    }
                    if ($coupon->redemption_type == REDEMPTION_TYPE_ONETIME && $invoiceCoupons->count() > 0) {
                        $couponDiscount = 0;
                    } elseif ($coupon->redemption_type == REDEMPTION_TYPE_LIMITED_NUMBER && $invoiceCoupons->count() > $coupon->maximum_redemption - 1) {
                        $couponDiscount = 0;
                    }
                }
            }

            $taxSetting = TaxSetting::where('product_id', $plan->product_id)->where('plan_id', $plan->id)->first();

            if (!is_null($taxSetting)) {
                if ($taxSetting->tax_type == TAX_TYPE_FLAT) {
                    $tax = $taxSetting->tax_amount;
                } else {
                    $tax = $price * $taxSetting->tax_amount * 0.01;
                }
            }

            $subtotal = $subscription->amount + $tax + $subscription->shipping_charge + $subscription->setup_fee;
            $order = new Order();
            $order->user_id = $subscription->user_id;
            $order->order_id = uniqid();
            $order->customer_id = $user->id;
            $order->product_id = $subscription->product_id;
            $order->plan_id = $subscription->plan_id;
            $order->invoice_id = $invoice->id;
            $order->gateway_id = $gateway->id;
            $order->subscription_id = $subscription->id;
            $order->shipping_cost = $subscription->shipping_charge;
            $order->setup_fees = $subscription->setup_fee;
            $order->tax_amount = $tax;
            $order->tax_type = $taxSetting?->tax_type ?? TAX_TYPE_FLAT;
            $order->conversion_rate = $gatewayCurrency->conversion_rate;
            $order->payment_status = PAYMENT_STATUS_PENDING;
            $order->system_currency = Currency::where('current_currency', 'on')->first()->currency_code;
            $order->gateway_currency = $gatewayCurrency->currency;

            $order->amount = $price;
            $order->discount = $couponDiscount;
            $order->discount_type = $couponDiscountType;

            $order->subtotal = $subtotal;
            $order->total = $subtotal - $couponDiscount;
            $order->transaction_amount = $order->total * $gatewayCurrency->conversion_rate;
            $order->save();

            $invoice->coupon_id = $couponId;
            $invoice->coupon_code = $couponCode;
            $invoice->save();
            if ($gateway->slug == 'bank') {
                $bank = Bank::where(['user_id' => $userId, 'gateway_id' => $gateway->id])->find($request->bank_id);
                if (is_null($bank)) {
                    throw new Exception(__('The bank not found'));
                }
                $bank_id = $bank->id;
                $deposit_by = $user->name;
                $deposit_slip_id = null;
                if ($request->hasFile('bank_slip')) {
                    $newFile = new FileManager();
                    $uploaded = $newFile->upload('Order', $request->bank_slip);
                    if ($uploaded) {
                        $deposit_slip_id = $uploaded->id;
                    }
                } else {
                    throw new Exception(__('The bank slip is required'));
                }
                $order->bank_id = $bank_id;
                $order->bank_deposit_by = $deposit_by;
                $order->bank_deposit_slip_id = $deposit_slip_id;
                $order->payment_id = uniqid('BNK');
                $order->save();
                DB::commit();
                $message = __('Bank Details Sent Successfully! Wait for approval');
                return $this->success($data, $message);
            } elseif ($gateway->slug == 'cash') {
                $order->payment_id = uniqid('CAS');
                $order->save();
                DB::commit();
                $message = __('Cash Payment Request Sent Successfully! Wait for approval');
                return $this->success($data, $message);
            } else {
                $object = [
                    'id' => $order->id,
                    'callback_url' => route('subscription.verify'),
                    'currency' => $gatewayCurrency->currency,
                    'user_id' => $userId,
                ];

                $payment = new Payment($gateway->slug, $object);
                $responseData = $payment->makePayment($order->total);
                if ($responseData['success']) {
                    $order->payment_id = $responseData['payment_id'];
                    $order->save();
                    $data['redirect_url'] = $responseData['redirect_url'];
                    DB::commit();
                    return $this->success($data);
                } else {
                    throw new Exception($responseData['message']);
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function userCreate($user_id, $first_name, $last_name, $email, $phone, $company)
    {
        $user = User::where('email', $email)->first();
        if (is_null($user)) {
            $user =  new User();
            $user->name = $first_name . ' ' . $last_name;
            $user->created_by = $user_id;
            $user->mobile = $phone;
            $user->company_name = $company;
            $user->email = $email;
            $user->password = Hash::make(rand(111111, 999999));
            $user->role = USER_ROLE_CUSTOMER;
            $user->save();
        }

        return $user;
    }

    public function userDetailsUpdate(
        $user_id,
        $basic_first_name,
        $basic_last_name,
        $basic_email,
        $basic_phone,
        $basic_company,
        $billing_address,
        $billing_zip_code,
        $billing_city,
        $billing_state,
        $billing_country,
        $shipping_address,
        $shipping_method,
        $shipping_zip_code,
        $shipping_city,
        $shipping_state,
        $shipping_country,
        $basic_info = null,
        $billing_info = null,
        $shipping_info = null,
    ) {
        $userDetails =  UserDetails::updateOrCreate([
            'user_id' => $user_id
        ], [
            'user_id' => $user_id,
            'basic_first_name' => $basic_first_name,
            'basic_last_name' => $basic_last_name,
            'basic_phone' => $basic_phone,
            'basic_email' => $basic_email,
            'basic_company' => $basic_company,
            'billing_address' => $billing_address,
            'billing_zip_code' => $billing_zip_code,
            'billing_city' => $billing_city,
            'billing_state' => $billing_state,
            'billing_country' => $billing_country,
            'shipping_zip_code' => $shipping_zip_code,
            'shipping_city' => $shipping_city,
            'shipping_state' => $shipping_state,
            'shipping_country' => $shipping_country,
            'shipping_address' => $shipping_address,
            'shipping_method' => $shipping_method,
            'basic_info' => json_encode($basic_info),
            'billing_info' => json_encode($billing_info),
            'shipping_info' => json_encode($shipping_info),
        ]);
        return $userDetails;
    }
}
