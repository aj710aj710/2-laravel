<?php

namespace App\Http\Services;

use App\Mail\CustomizeMail;
use App\Models\CheckoutPageSetting;
use App\Models\Coupon;
use App\Models\EmailTemplate;
use App\Models\FileManager;
use App\Models\Gateway;
use App\Models\InvoiceSetting;
use App\Models\License;
use App\Models\MailHistory;
use App\Models\Plan;
use App\Models\Product;
use App\Models\Setting;
use App\Models\TaxSetting;
use App\Models\User;
use App\Models\UserDetails;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SettingsService
{
    use ResponseTrait;

    public function cookieSettingUpdated($request)
    {
        $inputs = Arr::except($request->all(), ['_token']);

        foreach ($inputs as $key => $value) {
            $option = Setting::firstOrCreate(['option_key' => $key]);
            if ($request->hasFile('cookie_image') && $key == 'cookie_image') {
                $upload = settingImageStoreUpdate($value, $request->cookie_image);
                $option->option_value = $upload;
                $option->save();
            } else {
                $option->option_value = $value;
                $option->save();
            }
        }
        return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
    }

    public function commonSettingUpdate($request)
    {
        $inputs = Arr::except($request->all(), ['_token']);
        foreach ($inputs as $key => $value) {
            $option = Setting::firstOrCreate(['option_key' => $key]);
            if ($request->hasFile('cookie_image') && $key == 'cookie_image') {
                $upload = settingImageStoreUpdate($value, $request->cookie_image);
                $option->option_value = $upload;
                $option->save();
            } else {
                $option->option_value = $value;
                $option->save();
            }
        }

        return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
    }
    public function smsConfigurationStore($request)
    {
        $inputs = Arr::except($request->all(), ['_token']);

        foreach ($inputs as $key => $value) {

            $option = Setting::firstOrCreate(['option_key' => $key]);
            $option->option_value = $value;
            $option->save();
        }

        return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
    }

    public function emailTemplateConfig($request)
    {
        try {
            if (!in_array($request->category, [EMAIL_TEMPLATE_PAYMENT_SUCCESS, EMAIL_TEMPLATE_PAYMENT_FAILURE, EMAIL_TEMPLATE_INVOICE, EMAIL_TEMPLATE_SUBSCRIPTION_CANCELLATION, EMAIL_TEMPLATE_FORGOT_PASSWORD, EMAIL_TEMPLATE_PAYMENT_CANCEL, EMAIL_TEMPLATE_EMAIL_VERIFY])) {
                throw new Exception(__(SOMETHING_WENT_WRONG));
            }
            $data['template'] = EmailTemplate::updateOrCreate([
                'category' => $request->category,
                'user_id' => auth()->id()
            ], [
                'category' => $request->category,
                'user_id' => auth()->id()
            ]);
            $data['fields'] = emailTempFields($request->category);
            return $this->success($data);
        } catch (Exception $e) {
            return $this->error([], $e->getMessage());
        }
    }

    public function emailTemplateConfigUpdate($request)
    {
        DB::beginTransaction();
        try {
            if (!in_array($request->category, [EMAIL_TEMPLATE_PAYMENT_SUCCESS, EMAIL_TEMPLATE_PAYMENT_FAILURE, EMAIL_TEMPLATE_INVOICE, EMAIL_TEMPLATE_SUBSCRIPTION_CANCELLATION, EMAIL_TEMPLATE_FORGOT_PASSWORD, EMAIL_TEMPLATE_PAYMENT_CANCEL, EMAIL_TEMPLATE_EMAIL_VERIFY])) {
                throw new Exception(__(SOMETHING_WENT_WRONG));
            }
            EmailTemplate::updateOrCreate([
                'category' => $request->category,
                'user_id' => auth()->id()
            ], [
                'category' => $request->category,
                'user_id' => auth()->id(),
                'subject' => $request->subject,
                'body' => $request->body,
            ]);
            DB::commit();
            return $this->success([], __(UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], $e->getMessage());
        }
    }

    public function emailTemplateStatus($request)
    {
        DB::beginTransaction();
        try {
            $template = EmailTemplate::where('category', $request->category)->where('user_id', auth()->id())->first();
            if ($template && $template->subject) {
                $status = $template->status == ACTIVE ? DEACTIVATE : ACTIVE;
                $template->status = $status;
                $template->save();
            } else {
                throw new Exception(__('Please Config Email Template'));
            }
            DB::commit();
            return $this->success([], __(STATUS_UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], $e->getMessage());
        }
    }

    public function sendPaymentMail($subscription, $invoice, $order, $category)
    {
        $user = User::find($subscription->user_id);
        $customer = User::find($subscription->customer_id);
        $customerDetails = UserDetails::where('user_id', $customer->id)->first();
        $gateway = Gateway::find($order->gateway_id);
        $plan = Plan::find($subscription->plan_id);
        $license = License::where('product_plan', $subscription->plan_id)->first();
        $template = EmailTemplate::where('category', $category)->where('user_id', $user->id)->first();
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
                'billing_zip_code' => $customerDetails->billing_zip_code,
                'billing_address' => $customerDetails->billing_address,
                'billing_state' => $customerDetails->billing_state,
                'billing_city' => $customerDetails->billing_city,
                'billing_country' => $customerDetails->billing_country,
                'shipping_zip_code' => $customerDetails->shipping_zip_code,
                'shipping_address' => $customerDetails->shipping_address,
                'shipping_state' => $customerDetails->shipping_state,
                'shipping_city' => $customerDetails->shipping_city,
                'shipping_country' => $customerDetails->shipping_country,
                'plan_name' => $plan->name,
                'plan_price' => $plan->price,
                'quantity' => 01,
                'subtotal' => $order->subtotal,
                'discount' => $order->discount,
                'total' => $order->total,
                'payment_status' => $order->payment_status == PAYMENT_STATUS_PAID ? __('Paid') : __('Unpaid'),
                'invoice_id' => $invoice->invoice_id,
                'due_date' => $invoice->due_date,
                'order_date' => $invoice->created_at?->format('Y-m-d'),
                'gateway_name' => $gateway->title,
                'license_name' => $license?->name,
                'license_code' => $license?->code,
                'link' => '<a href="' . route('invoice', encrypt($invoice->id)) . '">' . __('Download Link') . '</a>',
            ];

            $emailTemplateContent = replaceBrackets($template->body, $customizedFieldsArray);
            if ($emailTemplateContent) {
                $this->sendCustomizeMail($customer->email, $template->subject, $subscription->user_id, $emailTemplateContent);
            }
        }
    }

    public function sendForgotMail($email)
    {
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now()
        ]);
        $template = EmailTemplate::where('category', EMAIL_TEMPLATE_FORGOT_PASSWORD)->first();
        if ($template) {
            $customizedFieldsArray = [
                'app_name' => getOption('app_name'),
                'app_email' => getOption('app_email'),
                'link' => '<a href="' . route('password.reset.verify', $token) . '">' . __('Link') . '</a>',
            ];
            $adminUser = User::where('role', USER_ROLE_ADMIN)->first();
            $emailTemplateContent = replaceBrackets($template->body, $customizedFieldsArray);
            if ($emailTemplateContent) {
                $this->sendCustomizeMail($email, $template->subject, $adminUser->id, $emailTemplateContent);
            }
        }
    }

    public static function sendCustomizeMail($email, $subject, $user_id, $content)
    {
        if (getOption('app_mail_status', 0) == 1 && env('MAIL_USERNAME')) {
            if (!is_null($email)) {
                try {
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $details['subject'] = $subject;
                        $details['content'] = $content;
                        Mail::to($email)->send(new CustomizeMail($details));
                        Log::channel('mail-history')->info('email : ' . $email . ', subject : ' . $subject .  ', date : ' . date('d-m-Y'));
                        self::sentMailHistoryStore($user_id, $email, $subject, $content, SMS_STATUS_DELIVERED);
                    } else {
                        self::sentMailHistoryStore($user_id, $email, $subject, $content, SMS_STATUS_FAILED, 'Email ' . $email . ' is not valid');
                        throw new Exception('Email ' . $email . ' is not valid');
                    }
                } catch (Exception $e) {
                    Log::channel('mail-history')->info($e->getMessage());
                    self::sentMailHistoryStore($user_id, $email, $subject, $content, SMS_STATUS_FAILED, $e->getMessage());
                }
                return 'success';
            } else {
                return __('No email found');
            }
        } else {
            return __('Smtp setting not enabled');
        }
    }

    public function emailTest($request)
    {
        DB::beginTransaction();
        try {
            if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception(__('Email Not Valid'));
            }
            if (!in_array($request->category, array_keys(emailTemplates()))) {
                throw new Exception(__(SOMETHING_WENT_WRONG));
            }
            $template = EmailTemplate::where('category', $request->category)->where('user_id', auth()->id())->first();
            if ($template) {
                $customizedFieldsArray = [
                    '{{app_name}}' => getOption('app_name'),
                    '{{app_email}}' => getOption('app_email'),
                ];
                $content = getEmailTemplateContent($template->body, $template->category, $customizedFieldsArray);
                $adminUser = User::where('role', USER_ROLE_ADMIN)->first();
                if ($content) {
                    $this->sendCustomizeMail($request->email, $template->subject, $adminUser->id, $content);
                }
            }
            DB::commit();
            return $this->success([], __(SENT_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], $e->getMessage());
        }
    }

    public static function sentMailHistoryStore($user_id, $email, $subject, $content, $status, $error = null)
    {
        $history = new MailHistory();
        $history->user_id = $user_id;
        $history->host = env('MAIL_HOST');
        $history->email = $email;
        $history->subject = $subject;
        $history->content = $content;
        $history->status = $status;
        $history->date = now();
        $history->error = $error;
        $history->save();
    }

    // checkout page setting
    public function checkoutPageUpdate($request)
    {
        DB::beginTransaction();
        try {
            $setting = CheckoutPageSetting::where('user_id', auth()->id())->first();
            if (is_null($setting)) {
                $setting = new CheckoutPageSetting();
            }
            $setting->user_id = auth()->id();
            if ($request->step == FORM_STEP_ONE) {
                $setting->title = $request->title;
                $setting->text_size = $request->text_size;
                $setting->text_color = $request->text_color;
                if ($request->hasFile('image')) {
                    $existFile = FileManager::where('id', $setting->image)->first();
                    if ($existFile) {
                        $existFile->removeFile();
                        $uploaded = $existFile->upload('CheckoutPageSetting', $request->image, '', $existFile->id);
                    } else {
                        $newFile = new FileManager();
                        $uploaded = $newFile->upload('CheckoutPageSetting', $request->image);
                    }
                    if ($uploaded) {
                        $setting->image = $uploaded->id;
                    } else {
                        throw new Exception(__('Image Not Uploaded.'));
                    }
                }
                $data['step'] = 'nextStep1';
            } elseif ($request->step == FORM_STEP_TWO) {
                $data = [];
                if (isset($request['basic']['type'])) {
                    foreach ($request['basic']['type'] as $key => $type) {
                        $data[] = [
                            'type' => $type,
                            'name' => strtolower(preg_replace('/\s+/', '', $request['basic']['label'][$key])),
                            'label' => $request['basic']['label'][$key],
                            'placeholder' => $request['basic']['placeholder'][$key],
                        ];
                    }
                }
                $setting->basic_info = json_encode($data);
                $data['step'] = 'nextStep2';
            } elseif ($request->step == FORM_STEP_THREE) {
                $data = [];
                if (isset($request['billing']['type'])) {
                    foreach ($request['billing']['type'] as $key => $type) {
                        $data[] = [
                            'type' => $type,
                            'name' => strtolower(preg_replace('/\s+/', '', $request['billing']['label'][$key])),
                            'label' => $request['billing']['label'][$key],
                            'placeholder' => $request['billing']['placeholder'][$key],
                        ];
                    }
                }
                $setting->billing_info = json_encode($data);
                $data['step'] = 'nextStep3';
            } elseif ($request->step == FORM_STEP_FOUR) {
                $data = [];
                if (isset($request['shipping']['type'])) {
                    foreach ($request['shipping']['type'] as $key => $type) {
                        $data[] = [
                            'type' => $type,
                            'name' => strtolower(preg_replace('/\s+/', '', $request['shipping']['label'][$key])),
                            'label' => $request['shipping']['label'][$key],
                            'placeholder' => $request['shipping']['placeholder'][$key],
                        ];
                    }
                }
                $setting->shipping_info = json_encode($data);
                $setting->shipping_method = $request->shipping_method == SHIPPING_METHOD_FREE ? SHIPPING_METHOD_FREE : SHIPPING_METHOD_PAID;
                $data['step'] = 'nextStep4';
            } elseif ($request->step == FORM_STEP_FIVE) {
                if ($request->gateways) {
                    $setting->payment = json_encode($request->gateways);
                    $data['gateways'] = $setting->payment;
                    $data['step'] = 'nextStep5';
                } else {
                    throw new Exception(__('Please Select Payment Gateway'));
                }
            } elseif ($request->step == FORM_STEP_SIX) {
                $setting->status = $request->status == CHECKOUT_PAGE_SETTING_STATUS_ACTIVE ? CHECKOUT_PAGE_SETTING_STATUS_ACTIVE : CHECKOUT_PAGE_SETTING_STATUS_PENDING;
                $data['step'] = 'lastStep';
            }
            $setting->save();
            DB::commit();

            return $this->success($data, __(UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], $e->getMessage());
        }
    }

    public function invoiceUpdate($request)
    {
        DB::beginTransaction();
        try {
            $invoice = InvoiceSetting::where('user_id', auth()->id())->first();
            if (is_null($invoice)) {
                $invoice = new InvoiceSetting();
            }
            $invoice->user_id = auth()->id();
            $invoice->type = INVOICE_SETTING_TYPE_ORDER;
            $invoice->title = $request->title;
            $invoice->company_info = $request->company_info;
            $invoice->prefix = $request->prefix;
            $invoice->info_one = $request->info_one;
            $invoice->info_two = $request->info_two;
            $invoice->info_three = $request->info_three;
            $invoice->footer_text = $request->footer_text;
            $invoice->column = json_encode($request->column);

            if ($request->hasFile('logo')) {
                $existFile = FileManager::where('id', $invoice->logo)->first();
                if ($existFile) {
                    $existFile->removeFile();
                    $uploaded = $existFile->upload('InvoiceSetting', $request->logo, 'invoice-setting', $existFile->id);
                } else {
                    $newFile = new FileManager();
                    $uploaded = $newFile->upload('InvoiceSetting', $request->logo, 'invoice-setting');
                }
                if ($uploaded) {
                    $invoice->logo = $uploaded->id;
                } else {
                    throw new Exception(__('Image Not Uploaded.'));
                }
            }
            $invoice->save();
            DB::commit();

            return $this->success([], __(UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], $e->getMessage());
        }
    }

    public function checkoutPageSetting()
    {
        return CheckoutPageSetting::where('user_id', auth()->id())->first();
    }

    public function invoiceSettingInfo()
    {
        return InvoiceSetting::where('user_id', auth()->id())->first();
    }

    public function checkoutPageSettingByUserId($userId)
    {
        return CheckoutPageSetting::where('user_id', $userId)->where('status', CHECKOUT_PAGE_SETTING_STATUS_ACTIVE)->first();
    }

    public function getAllProduct()
    {
        return Product::where('user_id', auth()->id())->get();
    }

    public function getPlan($id)
    {
        return  Plan::where('product_id', $id)->get();
    }

    public function getPlanByProductIds($ids)
    {
        return  Plan::whereIn('product_id', $ids)->get();
    }

    public function getCouponInfo($request)
    {
        try {
            if (is_null($request->code) || is_null($request->plan_id)) {
                throw new Exception(__(SOMETHING_WENT_WRONG));
            }
            $coupon = Coupon::query()
                ->where('user_id', $request->user_id)
                ->where('code', $request->code)
                ->where('product_plan', $request->plan_id)
                ->where('status', STATUS_ACTIVE)
                ->select('discount_type', 'discount', 'valid_date')
                ->first();
            if (!$coupon) {
                throw new Exception(__('Coupon Not Found'));
            }
            if ($coupon->valid_date >= date('Y-m-d')) {
                $data['coupon'] = $coupon->makeHidden('valid_date');
            } else {
                throw new Exception(__('Coupon Expired'));
            }
            return $this->success($data, __('Coupon Apply Successfully!'));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], $e->getMessage());
        }
    }

    public function taxList()
    {
        $tax = TaxSetting::where('user_id', auth()->id())->with(['plan', 'product']);
        return datatables($tax)
            ->addIndexColumn()

            ->addColumn('product_name', function ($data) {
                return htmlspecialchars($data->product->name);
            })

            ->addColumn('plan_name', function ($data) {
                return htmlspecialchars($data->plan->name);
            })

            ->addColumn('status', function ($data) {
                if ($data->status == ACTIVE) {
                    return "<p class='zBadge zBadge-active'>" . __('Published') . "</p>";
                } else {
                    return "<p class='zBadge zBadge-pending'>" . __('Deactive') . "</p>";
                }
            })

            ->addColumn('tax_amount', function ($data) {
                if ($data->tax_type == DISCOUNT_TYPE_FLAT) {
                    return '<p>' . getCurrencyPlacement() . $data->tax_amount . '</p>';
                } else {
                    return '<span>' . $data->tax_amount . '%' . '</span>';
                }
            })
            ->addColumn('action', function ($data) {
                return '<ul class="d-flex align-items-center cg-5 justify-content-lg-end">
                            <li class="d-flex gap-2">
                                <button onclick="getEditModal(\'' . route('user.settings.tax.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one border-0 bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="Edit">
                                    <img src="' . asset('assets/images/icon/edit.svg') . '" alt="edit" />
                                </button>
                                <button onclick="deleteItem(\'' . route('user.settings.tax.delete', $data->id) . '\', \'taxDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle border-0 bd-one bd-c-ededed bg-white" title="Delete">
                                    <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                                </button>
                            </li>
                        </ul>';
            })
            ->rawColumns(['status', 'action', 'tax_amount'])
            ->make(true);
    }

    public function taxDataStore($request)
    {
        $authUser = auth()->id();
        try {
            DB::beginTransaction();
            $id = $request->get('id', 0);
            $tax = TaxSetting::find($id);
            if (is_null($tax)) {
                $tax = new TaxSetting();
            }
            $tax->tax_rule_name = $request->tax_rule_name;
            $tax->user_id = $authUser;
            $tax->product_id = $request->product_id;
            $tax->plan_id = $request->plan_id;
            $tax->tax_type = $request->tax_type;
            $tax->tax_amount = $request->tax_amount;
            $tax->status = isset($request->status) ? $request->status : ACTIVE;
            $tax->save();
            DB::commit();
            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function taxDataDelete($id)
    {
        try {
            DB::beginTransaction();
            $event = TaxSetting::where('id', $id)->first();
            $event->delete();
            DB::commit();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function taxDataEdit($id)
    {
        return TaxSetting::where('id', $id)->with(['plan', 'product'])->firstOrFail();
    }
}
