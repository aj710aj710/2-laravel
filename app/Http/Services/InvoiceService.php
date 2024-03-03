<?php

namespace App\Http\Services;

use App\Models\EmailTemplate;
use App\Models\Invoice;
use App\Models\InvoiceSetting;
use App\Models\Subscription;
use App\Models\User;
use App\Traits\ResponseTrait;
use Doctrine\DBAL\Driver\Exception;
use Illuminate\Support\Facades\Log;

class InvoiceService
{
    use ResponseTrait;

    public function makeInvoice($recurring = 0, $subscription_id)
    {
        try {
            $subscriptionData = Subscription::find($subscription_id);
            $dataObj = new Invoice();
            $dataObj->user_id = $subscriptionData->user_id;
            $dataObj->customer_id = $subscriptionData->customer_id;
            $dataObj->product_id = $subscriptionData->product_id;
            $dataObj->plan_id = $subscriptionData->plan_id;
            $dataObj->subscription_id = $subscriptionData->id;
            $dataObj->due_date = now()->addDays($subscriptionData->due_day)->format('Y-m-d');
            $dataObj->amount = $subscriptionData->amount;
            $dataObj->setup_fees = $subscriptionData->setup_fee ?? 0;
            $dataObj->shipping_charge = $subscriptionData->shipping_charge;
            $dataObj->is_recurring = $recurring;
            $dataObj->save();
            if ($dataObj->id) {
                $invoiceSettingData = InvoiceSetting::where('user_id', $dataObj->user_id)->first();
                $invoiceId = (isset($invoiceSettingData->prefix) && $invoiceSettingData->prefix != null) ? $invoiceSettingData->prefix . sprintf('%06d', $dataObj->id) : 'INV' . sprintf('%06d', $dataObj->id);
                Invoice::where('id', $dataObj->id)->update(['invoice_id' => $invoiceId]);
            }
            Log::info('Invoice Created Successfully. Id - ' . $dataObj->id);
            return $dataObj;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
        }
    }

    public function invoiceMailToCustomer($invoice)
    {
        try {
            if (getOption('app_mail_status') == 1) {
                if ($invoice) {
                    $template = EmailTemplate::where('category', EMAIL_TEMPLATE_INVOICE)->where('user_id', $invoice->user_id)->first();
                    $user = User::find($invoice->user_id);
                    $customer = User::find($invoice->customer_id);
                    if ($template) {
                        $customizedFieldsArray = [
                            'app_name' => getOption('app_name'),
                            'app_email' => getOption('app_email'),
                            'user_name' => $user->name,
                            'customer_name' => $customer->name,
                            'customer_email' => $customer->email,
                            'customer_phone' => $customer->phone,
                            'customer_zip' => $customer->zip,
                            'customer_address' => $customer->address,
                            'customer_city' => $customer->city,
                            'customer_state' => $customer->state,
                            'customer_country' => $customer->country,
                            'invoice_id' => $invoice->invoice_id,
                            'due_date' => $invoice->due_date,
                            'order_date' => $invoice->created_at?->format('Y-m-d'),
                            'link' => '<a href="' . route('invoice', encrypt($invoice->id)) . '">' . __('Checkout Link') . '</a>',
                        ];

                        $emailTemplateContent = replaceBrackets($template->body, $customizedFieldsArray);
                        if ($emailTemplateContent) {
                            $settingsService = new SettingsService;
                            $settingsService->sendCustomizeMail($customer->email, $template->subject, $invoice->user_id, $emailTemplateContent);
                        }
                    }
                }
            }
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
        }
    }
}
