<?php

use App\Http\Controllers\AddonUpdateController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GatewayController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\VersionUpdateController;
use App\Http\Controllers\Admin\EmailTemplateController;
use Illuminate\Support\Facades\Route;

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

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('product-sold-out-chart-data', [DashboardController::class, 'productSoldOutChartData'])->name('product-sold-out-chart-data');
Route::get('daily-subscriber-chart-data', [DashboardController::class, 'dailySubscriberChartData'])->name('daily-subscriber-chart-data');

Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {

    Route::get('application-settings', [SettingController::class, 'applicationSetting'])->name('application-settings');
    Route::get('affiliate-settings', [SettingController::class, 'affiliateSetting'])->name('affiliate.settings');
    Route::get('configuration-settings', [SettingController::class, 'configurationSetting'])->name('configuration-settings');
    Route::get('configuration-settings/configure', [SettingController::class, 'configurationSettingConfigure'])->name('configuration-settings.configure');
    Route::get('configuration-settings/help', [SettingController::class, 'configurationSettingHelp'])->name('configuration-settings.help');
    Route::post('application-settings-update', [SettingController::class, 'applicationSettingUpdate'])->name('application-settings.update');
    Route::post('configuration-settings-update', [SettingController::class, 'configurationSettingUpdate'])->name('configuration-settings.update');
    Route::post('application-env-update', [SettingController::class, 'saveSetting'])->name('settings_env.update');
    Route::get('color-settings', [SettingController::class, 'colorSettings'])->name('color-settings');

    Route::group(['prefix' => 'currency', 'as' => 'currencies.'], function () {
        Route::get('', [CurrencyController::class, 'index'])->name('index');
        Route::post('currency', [CurrencyController::class, 'store'])->name('store');
        Route::get('edit/{id}', [CurrencyController::class, 'edit'])->name('edit');
        Route::patch('update/{id}', [CurrencyController::class, 'update'])->name('update');
        Route::post('delete/{id}', [CurrencyController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'language', 'as' => 'languages.'], function () {
        Route::get('/', [LanguageController::class, 'index'])->name('index');
        Route::post('store', [LanguageController::class, 'store'])->name('store');
        Route::get('edit/{id}/{iso_code?}', [LanguageController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [LanguageController::class, 'update'])->name('update');
        Route::get('translate/{id}', [LanguageController::class, 'translateLanguage'])->name('translate');
        Route::post('update-translate/{id}', [LanguageController::class, 'updateTranslate'])->name('update.translate');
        Route::post('delete/{id}', [LanguageController::class, 'delete'])->name('delete');
        Route::post('update-language/{id}', [LanguageController::class, 'updateLanguage'])->name('update-language');
        Route::get('translate/{id}/{iso_code?}', [LanguageController::class, 'translateLanguage'])->name('translate');
        Route::get('update-translate/{id}', [LanguageController::class, 'updateTranslate'])->name('update.translate');
        Route::post('import', [LanguageController::class, 'import'])->name('import')->middleware('isDemo');
    });

    Route::get('storage-settings', [SettingController::class, 'storageSetting'])->name('storage.index');
    Route::post('storage-settings', [SettingController::class, 'storageSettingsUpdate'])->name('storage.update');
    Route::get('social-login-settings', [SettingController::class, 'socialLoginSetting'])->name('social-login');
    Route::get('google-recaptcha-settings', [SettingController::class, 'googleRecaptchaSetting'])->name('google-recaptcha');
    Route::get('google-analytics-settings', [SettingController::class, 'googleAnalyticsSetting'])->name('google.analytics');

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('store', [UserController::class, 'store'])->name('store')->middleware('isDemo');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [UserController::class, 'update'])->name('update')->middleware('isDemo');
        Route::get('delete/{id}', [UserController::class, 'delete'])->name('delete')->middleware('isDemo');
    });

    Route::get('mail-configuration', [SettingController::class, 'mailConfiguration'])->name('mail-configuration');
    Route::post('mail-configuration', [SettingController::class, 'mailConfiguration'])->name('mail-configuration');
    Route::post('mail-test', [SettingController::class, 'mailTest'])->name('mail.test');

    Route::get('sms-configuration', [SettingController::class, 'smsConfiguration'])->name('sms-configuration');
    Route::post('sms-configuration', [SettingController::class, 'smsConfigurationStore'])->name('sms-configuration');
    Route::post('sms-test', [SettingController::class, 'smsTest'])->name('sms.test');


    //Start:: Maintenance Mode
    Route::get('maintenance-mode-changes', [SettingController::class, 'maintenanceMode'])->name('maintenance');
    Route::post('maintenance-mode-changes', [SettingController::class, 'maintenanceModeChange'])->name('maintenance.change');
    //End:: Maintenance Mode

    Route::get('cache-settings', [SettingController::class, 'cacheSettings'])->name('cache-settings');
    Route::get('cache-update/{id}', [SettingController::class, 'cacheUpdate'])->name('cache-update');
    Route::get('storage-link', [SettingController::class, 'storageLink'])->name('storage.link');
    Route::get('security-settings', [SettingController::class, 'securitySettings'])->name('security.settings');

    Route::group(['prefix' => 'gateway', 'as' => 'gateway.'], function () {
        Route::get('/', [GatewayController::class, 'index'])->name('index');
        Route::post('store', [GatewayController::class, 'store'])->name('store')->middleware('isDemo');
        Route::get('get-info', [GatewayController::class, 'getInfo'])->name('get.info');
        Route::get('get-currency-by-gateway', [GatewayController::class, 'getCurrencyByGateway'])->name('get.currency');
    });

    //Features Settings
    Route::get('cookie-settings', [SettingController::class, 'cookieSetting'])->name('cookie-settings');
    Route::post('cookie-settings-update', [SettingController::class, 'cookieSettingUpdated'])->name('cookie.settings.update');


    //common setting update
    Route::post('common-settings-update', [SettingController::class, 'commonSettingUpdate'])->name('common.settings.update')->middleware('isDemo');

    Route::get('email-template', [EmailTemplateController::class, 'emailTemplate'])->name('email-template');
    Route::get('email-template-config', [EmailTemplateController::class, 'emailTemplateConfig'])->name('email.template.config');
    Route::post('email-template-config-update', [EmailTemplateController::class, 'emailTemplateConfigUpdate'])->name('email.template.config.update');
});

Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
    Route::get('/', [ProfileController::class, 'myProfile'])->name('index');
    Route::get('change-password', [ProfileController::class, 'changePassword'])->name('change-password');
    Route::post('change-password', [ProfileController::class, 'changePasswordUpdate'])->name('change-password.update')->middleware('isDemo');
    Route::post('update', [ProfileController::class, 'update'])->name('update')->middleware('isDemo');
});

// customers route start
Route::get('customer-list', [UserController::class, 'customerList'])->name('customer.list');
Route::get('user-list', [UserController::class, 'userList'])->name('user.list');

Route::group(['prefix' => 'notification', 'as' => 'notification.'], function () {
    Route::get('notification-mark-all-as-read', [NotificationController::class, 'notificationMarkAllAsRead'])->name('notification-mark-all-as-read');
    Route::get('notification-mark-as-read/{id}', [NotificationController::class, 'notificationMarkAsRead'])->name('notification-mark-as-read');
});

// version update
Route::get('version-update', [VersionUpdateController::class, 'versionFileUpdate'])->name('file-version-update')->middleware('isDemo');
Route::post('version-update', [VersionUpdateController::class, 'versionFileUpdateStore'])->name('file-version-update-store')->middleware('isDemo');
Route::get('version-update-execute', [VersionUpdateController::class, 'versionUpdateExecute'])->name('file-version-update-execute')->middleware('isDemo');
Route::get('version-delete', [VersionUpdateController::class, 'versionFileUpdateDelete'])->name('file-version-delete')->middleware('isDemo');

Route::group(['prefix' => 'addon', 'as' => 'addon.'], function () {
    Route::get('details/{code}', [AddonUpdateController::class, 'addonSaasDetails'])->name('details')->withoutMiddleware(['addon.update']);
    Route::post('store', [AddonUpdateController::class, 'addonSaasFileStore'])->name('store')->withoutMiddleware(['addon.update']);
    Route::post('execute', [AddonUpdateController::class, 'addonSaasFileExecute'])->name('execute')->withoutMiddleware(['addon.update']);
    Route::get('delete/{code}', [AddonUpdateController::class, 'addonSaasFileDelete'])->name('delete')->withoutMiddleware(['addon.update']);
});
