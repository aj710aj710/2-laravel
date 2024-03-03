<?php

use App\Http\Controllers\CouponController;
use App\Http\Controllers\licenseController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\AffiliateController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\SettingController;
use App\Http\Controllers\User\UserEmailVerifyController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WebhookEventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\SubscriptionController;
use App\Http\Controllers\User\InvoiceController;
use App\Http\Controllers\User\ReportController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('monthly-subscriber', [DashboardController::class, 'monthlySubscriber'])->name('monthly-subscriber');
Route::get('monthly-revenue', [DashboardController::class, 'monthlyRevenue'])->name('monthly-revenue');
Route::get('product-sold-out-chart-data', [DashboardController::class, 'productSoldOutChartData'])->name('product-sold-out-chart-data');
Route::get('daily-subscriber-chart-data', [DashboardController::class, 'dailySubscriberChartData'])->name('daily-subscriber-chart-data');
Route::get('user/profile/{id}', [ProfileController::class, 'view'])->name('alumnus.view');

Route::group(['prefix' => 'settings'], function () {
    Route::get('/', [SettingController::class, 'settings'])->name('settings');
    Route::post('change-password', [SettingController::class, 'changePasswordUpdate'])->name('change-password')->middleware('isDemo');
    Route::post('setting-update', [SettingController::class, 'settingUpdate'])->name('setting_update');
    Route::post('profile-update', [ProfileController::class, 'profileUpdate'])->name('settings.profile.update');
    Route::get('email-template-config', [SettingController::class, 'emailTemplateConfig'])->name('settings.email.template.config');
    Route::post('email-template-config-update', [SettingController::class, 'emailTemplateConfigUpdate'])->name('settings.email.template.config.update');
    Route::get('email-template-status', [SettingController::class, 'emailTemplateStatus'])->name('settings.email.template.status');
    Route::post('email-test', [SettingController::class, 'emailTest'])->name('settings.email.test');
    Route::post('checkout-page-update', [SettingController::class, 'checkoutPageUpdate'])->name('settings.checkout.page.update');
    Route::post('invoice-update', [SettingController::class, 'invoiceUpdate'])->name('settings.invoice.update');
    Route::get('settings-get-plan', [SettingController::class, 'getPlanData'])->name('settings.get.plan.data');
    Route::get('get-plan-product', [SettingController::class, 'getPlanByProduct'])->name('get.plan.by.product');

    Route::post('tax-store', [SettingController::class, 'taxStore'])->name('settings.tax.store');
    Route::get('tax-edit/{id}', [SettingController::class, 'taxEdit'])->name('settings.tax.edit');
    Route::post('tax-update/{id}', [SettingController::class, 'taxUpdate'])->name('settings.tax.update');
    Route::post('tax-delete/{id}', [SettingController::class, 'deleteTax'])->name('settings.tax.delete');
});

Route::group(['prefix' => 'affiliate', 'as' => 'affiliate.'], function () {
    Route::get('/', [AffiliateController::class, 'index'])->name('index');
    Route::get('info', [AffiliateController::class, 'getInfo'])->name('info');
    Route::post('status-change', [AffiliateController::class, 'statusChange'])->name('status.change');
    Route::get('history', [AffiliateController::class, 'historyForUser'])->name('history');
    Route::get('request', [AffiliateController::class, 'withdrawRequestForUser'])->name('request.user');

    Route::group(['prefix' => 'withdraw', 'as' => 'withdraw.'], function () {
        Route::get('request-status', [AffiliateController::class, 'withdrawRequestByStatus'])->name('request.status');
        Route::post('request-status-change', [AffiliateController::class, 'withdrawRequestStatusChange'])->name('request.status.change');
        Route::get('request-status-edit/{id}', [AffiliateController::class, 'ordersEdit'])->name('request.status.edit');
    });

    Route::group(['prefix' => 'config', 'as' => 'config.'], function () {
        Route::get('list', [AffiliateController::class, 'configList'])->name('list');
        Route::post('store', [AffiliateController::class, 'configStore'])->name('store');
        Route::get('info', [AffiliateController::class, 'configInfo'])->name('info');
        Route::post('delete/{id}', [AffiliateController::class, 'configDelete'])->name('delete');
    });
});

Route::post('phone-verification-sms-send', [ProfileController::class, 'smsSend'])->name('phone.verification.sms.send');
Route::get('phone-verification-sms-resend', [ProfileController::class, 'smsReSend'])->name('phone.verification.sms.resend');
Route::post('phone-verification-sms-verify', [ProfileController::class, 'smsVerify'])->name('phone.verification.sms.verify');

Route::post('email/verified/{token}', [UserEmailVerifyController::class, 'emailVerified'])->name('email.verified')->withoutMiddleware('is_email_verify');
Route::get('email/verify/{token}', [UserEmailVerifyController::class, 'emailVerify'])->name('email.verify')->withoutMiddleware('is_email_verify');
Route::post('email/verify/resend/{token}', [UserEmailVerifyController::class, 'emailVerifyResend'])->name('email.verify.resend')->withoutMiddleware('is_email_verify');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('dashboard/chart-data', [DashboardController::class, 'chartData'])->name('dashboard_chart_data');

//notification  route start
Route::group(['prefix' => 'notification', 'as' => 'notification.'], function () {
    Route::get('all', [NotificationController::class, 'allNotification'])->name('all');
    Route::get('mark-as-read', [NotificationController::class, 'notificationMarkAsRead'])->name('mark-as-read');
    Route::get('view/{id}', [NotificationController::class, 'notificationView'])->name('view');
    Route::get('delete/{id}', [NotificationController::class, 'notificationDelete'])->name('delete');

    Route::get('notification-mark-all-as-read', [NotificationController::class, 'notificationMarkAllAsRead'])->name('notification-mark-all-as-read');
    Route::get('notification-mark-as-read/{id}', [NotificationController::class, 'notificationMarkAsRead'])->name('notification-mark-as-read');
});
// notification route end

Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
    Route::get('list', [ProductController::class, 'list'])->name('list');
    Route::post('store', [ProductController::class, 'store'])->name('store');
    Route::get('edit/{id}', [ProductController::class, 'edit'])->name('edit');
    Route::post('delete/{id}', [ProductController::class, 'delete'])->name('delete');
});

Route::group(['prefix' => 'plan', 'as' => 'plan.'], function () {
    Route::get('list/{product_id?}', [PlanController::class, 'list'])->name('list');
    Route::post('store', [PlanController::class, 'store'])->name('store');
    Route::get('list-for-dropdown/{product_id?}', [PlanController::class, 'listForDropdown'])->name('list-for-dropdown');
    Route::get('edit/{id}', [PlanController::class, 'edit'])->name('edit');
    Route::post('delete/{id}', [PlanController::class, 'delete'])->name('delete');
    Route::get('share/{id}', [PlanController::class, 'share'])->name('share');
});

Route::group(['prefix' => 'coupon', 'as' => 'coupon.'], function () {
    Route::get('list/{product_id?}', [CouponController::class, 'list'])->name('list');
    Route::post('store', [CouponController::class, 'store'])->name('store');
    Route::get('edit/{id}', [CouponController::class, 'edit'])->name('edit');
    Route::post('delete/{id}', [CouponController::class, 'delete'])->name('delete');
});

Route::group(['prefix' => 'license', 'as' => 'license.'], function () {
    Route::get('list/{product_id?}', [licenseController::class, 'list'])->name('list');
    Route::post('store', [licenseController::class, 'store'])->name('store');
    Route::get('edit/{id}', [licenseController::class, 'edit'])->name('edit');
    Route::post('delete/{id}', [licenseController::class, 'delete'])->name('delete');
});

Route::get('testing', [DashboardController::class, 'tester'])->name('testing');

//subscription route start
Route::group(['prefix' => 'subscription', 'as' => 'subscription.'], function () {
    Route::get('list/{plan_id?}', [SubscriptionController::class, 'list'])->name('list');
    Route::get('get-plan-data', [SubscriptionController::class, 'getPlanData'])->name('get.plan.data');
});
//subscription route end

//invoice route start
Route::group(['prefix' => 'invoice', 'as' => 'invoice.'], function () {
    Route::get('list/{plan_id?}', [InvoiceController::class, 'list'])->name('list');
    Route::get('view', [InvoiceController::class, 'invoiceView'])->name('view');
    Route::get('get-plan-data', [InvoiceController::class, 'getPlanData'])->name('get.plan.data');
    Route::get('print/{id}', [InvoiceController::class, 'invoicePrint'])->name('print');
    Route::get('download/{id}', [InvoiceController::class, 'invoiceDownload'])->name('download');
});
//invoice route end

// customers route start
Route::get('customer-list', [UserController::class, 'customerList'])->name('customer.list');
Route::get('customer-details/{id}', [UserController::class, 'customerDetails'])->name('customer.details');
Route::post('customer-delete/{id}', [UserController::class, 'customerDelete'])->name('customer.delete');
// customers route end

// order route start
Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
    Route::get('/', [OrderController::class, 'index'])->name('payment.status');
    Route::get('payment-show/{id}', [OrderController::class, 'paymentShow'])->name('payment.show');
    Route::get('payment-edit/{id}', [OrderController::class, 'paymentEdit'])->name('payment.edit');
    Route::post('payment-status-update', [OrderController::class, 'paymentUpdate'])->name('payment.status.update');
    Route::get('sales', [OrderController::class, 'sales'])->name('sales');
});
// order route end

//report route start
Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
    Route::get('products-list', [ReportController::class, 'productList'])->name('product.list');
    Route::get('sales-list', [ReportController::class, 'salesList'])->name('sales.list');
    Route::get('customer-list', [ReportController::class, 'customerList'])->name('customer.list');
});
//report route end

Route::group(['prefix' => 'webhook', 'as' => 'webhook.'], function () {
    Route::get('list', [WebhookController::class, 'webhookList'])->name('list');
    Route::post('store', [WebhookController::class, 'webhookStore'])->name('store');
    Route::get('edit/{id}', [WebhookController::class, 'webhookEdit'])->name('edit');
    Route::post('delete/{id}', [WebhookController::class, 'deleteWebhook'])->name('delete');
    Route::get('events', [WebhookEventController::class, 'events'])->name('events');
    Route::get('get-plan-data', [WebhookEventController::class, 'getPlanData'])->name('get.plan.data');
    Route::get('events-create', [WebhookEventController::class, 'eventsCreate'])->name('events-create');
});
