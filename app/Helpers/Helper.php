<?php

use App\Models\Currency;
use App\Models\EmailTemplate;
use App\Models\FileManager;
use App\Models\Language;
use App\Models\Meta;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\UserPackage;
use App\Models\Webhook;
use App\Models\WebhookEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Mail\EmailNotify;
use App\Models\AffiliateConfig;
use App\Models\AffiliateHistory;
use App\Models\Gateway;
use App\Models\Package;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;

if (!function_exists("getOption")) {
    function getOption($option_key, $default = NULL)
    {
        $system_settings = config('settings');

        if ($option_key && isset($system_settings[$option_key])) {
            return $system_settings[$option_key];
        } else {
            return $default;
        }
    }
}

function getSettingImage($option_key)
{

    if ($option_key && $option_key != null) {


        $setting = Setting::where('option_key', $option_key)->first();
        if (isset($setting->option_value) && isset($setting->option_value) != null) {

            $file = FileManager::select('path', 'storage_type')->find($setting->option_value);


            if (!is_null($file)) {
                if (Storage::disk($file->storage_type)->exists($file->path)) {

                    if ($file->storage_type == 'public') {
                        return asset('storage/' . $file->path);
                    }

                    return Storage::disk($file->storage_type)->url($file->path);
                }
            }
        }
    }
    return asset('assets/images/no-image.jpg');
}

function settingImageStoreUpdate($option_value, $requestFile)
{

    if ($requestFile) {

        /*File Manager Call upload*/
        if ($option_value && $option_value != null) {
            $new_file = FileManager::where('id', $option_value)->first();

            if ($new_file) {
                $new_file->removeFile();
                $uploaded = $new_file->upload('Setting', $requestFile, '', $new_file->id);
            } else {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('Setting', $requestFile);
            }
        } else {
            $new_file = new FileManager();
            $uploaded = $new_file->upload('Setting', $requestFile);
        }

        /*End*/

        return $uploaded->id;
    }

    return null;
}

function copyFolder($source, $destination)
{
    if (is_dir($source)) {
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true); // Create the destination directory if it doesn't exist
        }

        $dir = opendir($source);

        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                $src = $source . '/' . $file;
                $dest = $destination . '/' . $file;

                if (is_dir($src)) {
                    // If it's a directory, recursively call the function
                    copyFolder($src, $dest);
                } else {
                    // If it's a file, use copy() to copy it
                    copy($src, $dest);
                }
            }
        }

        closedir($dir);
    } else {
        // If the source is a file, use copy() to copy it
        copy($source, $destination);
    }
}

if (!function_exists("getDefaultImage")) {
    function getDefaultImage()
    {
        // return asset('assets/images/no-image.jpg');
        return asset('assets/images/icon/upload-img-1.svg');
    }
}

if (!function_exists("activeIfMatch")) {
    function activeIfMatch($path)
    {
        if (auth::user()->is_admin()) {
            return Request::is($path . '*') ? 'mm-active' : '';
        } else {
            return Request::is($path . '*') ? 'active' : '';
        }
    }
}

if (!function_exists("activeIfFullMatch")) {
    function activeIfFullMatch($path)
    {
        if (auth::user()->is_admin()) {
            return Request::is($path) ? 'mm-active' : '';
        } else {
            return Request::is($path) ? 'active' : '';
        }
    }
}

if (!function_exists("openIfFullMatch")) {
    function openIfFullMatch($path)
    {
        return Request::is($path) ? 'has-open' : '';
    }
}


if (!function_exists("toastMessage")) {
    function toastMessage($message_type, $message)
    {
        Toastr::$message_type($message, '', ['progressBar' => true, 'closeButton' => true, 'positionClass' => 'toast-top-right']);
    }
}

if (!function_exists("getDefaultLanguage")) {
    function getDefaultLanguage()
    {
        $language = Language::where('default', STATUS_ACTIVE)->first();
        if ($language) {
            $iso_code = $language->iso_code;
            return $iso_code;
        }

        return 'en';
    }
}

if (!function_exists("getCurrencySymbol")) {
    function getCurrencySymbol()
    {
        $currency = Currency::where('current_currency', STATUS_ACTIVE)->first();
        if ($currency) {
            $symbol = $currency->symbol;
            return $symbol;
        }

        return '';
    }
}

if (!function_exists("getIsoCode")) {
    function getIsoCode()
    {
        $currency = Currency::where('current_currency', STATUS_ACTIVE)->first();
        if ($currency) {
            $currency_code = $currency->currency_code;
            return $currency_code;
        }

        return '';
    }
}

if (!function_exists("getCurrencyPlacement")) {
    function getCurrencyPlacement()
    {
        $currency = Currency::where('current_currency', STATUS_ACTIVE)->first();
        $placement = 'before';
        if ($currency) {
            $placement = $currency->symbol;
            return $placement;
        }

        return $placement;
    }
}

if (!function_exists("showPrice")) {
    function showPrice($price)
    {
        $price = getNumberFormat($price);
        if (config('app.currencyPlacement') == 'after') {
            return $price . config('app.currencySymbol');
        } else {
            return config('app.currencySymbol') . $price;
        }
    }
}


if (!function_exists("getNumberFormat")) {
    function getNumberFormat($amount)
    {
        return number_format($amount, 2, '.', '');
    }
}

if (!function_exists("decimalToInt")) {
    function decimalToInt($amount)
    {
        return number_format(number_format($amount, 2, '.', '') * 100, 0, '.', '');
    }
}

if (!function_exists("intToDecimal")) {
}
function intToDecimal($amount)
{
    return number_format($amount / 100, 2, '.', '');
}

if (!function_exists("appLanguages")) {
    function appLanguages()
    {
        return Language::where('status', 1)->get();
    }
}

if (!function_exists("selectedLanguage")) {
    function selectedLanguage()
    {
        $language = Language::where('iso_code', session()->get('local'))->first();
        if (!$language) {
            $language = Language::find(1);
            if ($language) {
                $ln = $language->iso_code;
                session(['local' => $ln]);
                App::setLocale(session()->get('local'));
            }
        }

        return $language;
    }
}

if (!function_exists("getVideoFile")) {
    function getFile($path, $storageType)
    {
        if (!is_null($path)) {
            if (Storage::disk($storageType)->exists($path)) {

                if ($storageType == 'public') {
                    return asset('storage/' . $path);
                }

                if ($storageType == 'wasabi') {
                    return Storage::disk('wasabi')->url($path);
                }


                return Storage::disk($storageType)->url($path);
            }
        }

        return asset('assets/images/no-image.jpg');
    }
}

if (!function_exists("notificationForUser")) {
    function notificationForUser()
    {
        $instructor_notifications = \App\Models\Notification::where('user_id', auth()->user()->id)->where('user_type', 2)->where('is_seen', 'no')->orderBy('created_at', 'DESC')->get();
        $student_notifications = \App\Models\Notification::where('user_id', auth()->user()->id)->where('user_type', 3)->where('is_seen', 'no')->orderBy('created_at', 'DESC')->get();
        return array('instructor_notifications' => $instructor_notifications, 'student_notifications' => $student_notifications);
    }
}

if (!function_exists("adminNotifications")) {
    function adminNotifications()
    {
        return \App\Models\Notification::where('user_type', 1)->where('is_seen', 'no')->orderBy('created_at', 'DESC')->paginate(5);
    }
}

if (!function_exists('getSlug')) {
    function getSlug($text)
    {
        if ($text) {
            $data = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\|\\\]/", "", $text);
            $slug = preg_replace("/[\/_|+ -]+/", "-", $data);
            return $slug;
        }
        return '';
    }
}

if (!function_exists('setUserPackage')) {
    function setUserPackage($userId, $package, $duration, $orderId = NULL)
    {
        UserPackage::where(['user_id' => $userId])->whereIn('status', [ACTIVE])->update(['status' => DEACTIVATE]);
        UserPackage::create([
            'name' => $package->name,
            'user_id' => $userId,
            'package_id' => $package->id,
            'order_id' => $orderId,
            'customer_limit' => $package->customer_limit,
            'product_limit' => $package->product_limit,
            'subscription_limit' => $package->subscription_limit,
            'monthly_price' => $package->monthly_price,
            'yearly_price' => $package->yearly_price,
            'start_date' => now(),
            'end_date' => Carbon::now()->addDays($duration),
            'is_trail' => $package->is_trail,
            'status' => ACTIVE,
        ]);
    }
}

if (!function_exists('setUserGateway')) {
    function setUserGateway($userId)
    {
        $data = [
            ['user_id' => $userId, 'title' => 'Paypal', 'slug' => 'paypal', 'status' => DEACTIVATE, 'mode' => GATEWAY_MODE_SANDBOX, 'url' => '', 'key' => '', 'secret' => '', 'image' => 'assets/images/gateway-icon/paypal.png'],
            ['user_id' => $userId, 'title' => 'Stripe', 'slug' => 'stripe', 'status' => DEACTIVATE, 'mode' => GATEWAY_MODE_SANDBOX, 'url' => '', 'key' => '', 'secret' => '', 'image' => 'assets/images/gateway-icon/stripe.png'],
            ['user_id' => $userId, 'title' => 'Razorpay', 'slug' => 'razorpay', 'status' => DEACTIVATE, 'mode' => GATEWAY_MODE_SANDBOX, 'url' => '', 'key' => '', 'secret' => '', 'image' => 'assets/images/gateway-icon/razorpay.png'],
            ['user_id' => $userId, 'title' => 'Instamojo', 'slug' => 'instamojo', 'status' => DEACTIVATE, 'mode' => GATEWAY_MODE_SANDBOX, 'url' => '', 'key' => '', 'secret' => '', 'image' => 'assets/images/gateway-icon/instamojo.png'],
            ['user_id' => $userId, 'title' => 'Mollie', 'slug' => 'mollie', 'status' => DEACTIVATE, 'mode' => GATEWAY_MODE_SANDBOX, 'url' => '', 'key' => '', 'secret' => '', 'image' => 'assets/images/gateway-icon/mollie.png'],
            ['user_id' => $userId, 'title' => 'Paystack', 'slug' => 'paystack', 'status' => DEACTIVATE, 'mode' => GATEWAY_MODE_SANDBOX, 'url' => '', 'key' => '', 'secret' => '', 'image' => 'assets/images/gateway-icon/paystack.png'],
            ['user_id' => $userId, 'title' => 'Sslcommerz', 'slug' => 'sslcommerz', 'status' => DEACTIVATE, 'mode' => GATEWAY_MODE_SANDBOX, 'url' => '', 'key' => '', 'secret' => '', 'image' => 'assets/images/gateway-icon/sslcommerz.png'],
            ['user_id' => $userId, 'title' => 'Flutterwave', 'slug' => 'flutterwave', 'status' => DEACTIVATE, 'mode' => GATEWAY_MODE_SANDBOX, 'url' => '', 'key' => '', 'secret' => '', 'image' => 'assets/images/gateway-icon/flutterwave.png'],
            ['user_id' => $userId, 'title' => 'Mercadopago', 'slug' => 'mercadopago', 'status' => DEACTIVATE, 'mode' => GATEWAY_MODE_SANDBOX, 'url' => '', 'key' => '', 'secret' => '', 'image' => 'assets/images/gateway-icon/mercadopago.png'],
            ['user_id' => $userId, 'title' => 'Bank', 'slug' => 'bank', 'status' => DEACTIVATE, 'mode' => GATEWAY_MODE_SANDBOX, 'url' => '', 'key' => '', 'secret' => '', 'image' => 'assets/images/gateway-icon/bank.png'],
            ['user_id' => $userId, 'title' => 'Cash', 'slug' => 'cash', 'status' => DEACTIVATE, 'mode' => GATEWAY_MODE_SANDBOX, 'url' => '', 'key' => '', 'secret' => '', 'image' => 'assets/images/gateway-icon/cash.png'],
        ];
        Gateway::insert($data);
    }
}

if (!function_exists('userCurrentPackage')) {
    function userCurrentPackage($userId)
    {
        return UserPackage::query()
            ->where('status', ACTIVE)
            ->where('user_id', $userId)
            ->whereDate('end_date', '>=', now()->toDateTimeString())
            ->first();
    }
}

if (!function_exists('getExistingCustomers')) {
    function getExistingCustomers($userId = null)
    {
        $userId = is_null($userId) ? auth()->id() : $userId;
        $userPackage = userCurrentPackage($userId);

        if (is_null($userPackage)) {
            return 0;
        } else {
            $totalCount = User::query()
                ->where('created_by', $userId)
                ->where('role', USER_ROLE_CUSTOMER)
                ->count();
            return $totalCount;
        }
    }
}

if (!function_exists('getExistingProducts')) {
    function getExistingProducts($userId = null)
    {
        $userId = is_null($userId) ? auth()->id() : $userId;
        $userPackage = userCurrentPackage($userId);

        if (is_null($userPackage)) {
            return 0;
        } else {
            $totalCount = Product::query()
                ->where('user_id', $userId)
                ->count();
            return $totalCount;
        }
    }
}

if (!function_exists('getExistingSubscriptions')) {
    function getExistingSubscriptions($userId = null)
    {
        $userId = is_null($userId) ? auth()->id() : $userId;
        $userPackage = userCurrentPackage($userId);

        if (is_null($userPackage)) {
            return 0;
        } else {
            $totalCount = Subscription::query()
                ->where('user_id', $userId)
                ->count();
            return $totalCount;
        }
    }
}

if (!function_exists('getPackageOtherFields')) {
    function getPackageOtherFields($userId = null)
    {
        $userId = is_null($userId) ? auth()->id() : $userId;
        $userPackage = userCurrentPackage($userId);

        if (is_null($userPackage)) {
            return [];
        } else {
            $package = Package::find($userPackage->package_id);
            return json_decode($package->others);
        }
    }
}

if (!function_exists('getUserPackageLimit')) {
    function getUserPackageLimit($rule, $userId = null)
    {
        if (isAddonInstalled('SUBSAAS') < 1) {
            return true;
        }
        $userId = is_null($userId) ? auth()->id() : $userId;
        $userPackage = userCurrentPackage($userId);
        if (is_null($userPackage)) {
            return 0;
        }

        if ($rule == RULES_CUSTOMER) {
            $limit =  $userPackage->customer_limit;
            $used = User::query()->where('created_by', $userId)->where('role', USER_ROLE_CUSTOMER)->count();
            $remain = $limit - $used;
            $remain = $remain < 0 ? 0 : $remain;
            return $remain;
        } elseif ($rule == RULES_PRODUCT) {
            $limit =  $userPackage->product_limit;
            $used = Product::query()->where('user_id', $userId)->count();
            $remain = $limit - $used;
            $remain = $remain < 0 ? 0 : $remain;
            return $remain;
        } elseif ($rule = RULES_SUBSCRIPTION) {
            $limit =  $userPackage->subscription_limit;
            $used = Subscription::query()->where('user_id', $userId)->count();
            $remain = $limit - $used;
            $remain = $remain < 0 ? 0 : $remain;
            return $remain;
        }
    }
}

if (!function_exists('getCustomerCurrentBuildVersion')) {
    function getCustomerCurrentBuildVersion()
    {
        $buildVersion = getOption('build_version');

        if (is_null($buildVersion)) {
            return 1;
        }

        return (int) $buildVersion;
    }
}

if (!function_exists('setCustomerBuildVersion')) {
    function setCustomerBuildVersion($version)
    {
        $option = Setting::firstOrCreate(['option_key' => 'build_version']);
        $option->option_value = $version;
        $option->save();
    }
}

if (!function_exists('setCustomerCurrentVersion')) {
    function setCustomerCurrentVersion()
    {
        $option = Setting::firstOrCreate(['option_key' => 'current_version']);
        $option->option_value = config('app.current_version');
        $option->save();
    }
}


if (!function_exists('getCustomerCurrentBuildVersion')) {
    function getCustomerCurrentBuildVersion()
    {
        $buildVersion = getOption('build_version');

        if (is_null($buildVersion)) {
            return 1;
        }

        return (int) $buildVersion;
    }
}

if (!function_exists('getCustomerAddonBuildVersion')) {
    function getCustomerAddonBuildVersion($code)
    {
        $buildVersion = getOption($code . '_build_version', 0);
        if (is_null($buildVersion)) {
            return 0;
        }
        return (int) $buildVersion;
    }
}

if (!function_exists('isAddonInstalled')) {
    function isAddonInstalled($code)
    {
        $buildVersion = getOption($code . '_build_version', 0);
        $codeBuildVersion = getAddonCodeBuildVersion($code);
        if (is_null($buildVersion) || $codeBuildVersion == 0) {
            return 0;
        }
        return (int) $buildVersion;
    }
}

if (!function_exists('setCustomerAddonCurrentVersion')) {
    function setCustomerAddonCurrentVersion($code)
    {
        $option = Setting::firstOrCreate(['option_key' => $code . '_current_version']);
        if (config($code . '.current_version', 0) > 0) {
            $option->option_value = config($code . '.current_version', 0);
            $option->save();
        }
    }
}

if (!function_exists('setCustomerAddonBuildVersion')) {
    function setCustomerAddonBuildVersion($code, $version)
    {
        $option = Setting::firstOrCreate(['option_key' => $code . '_build_version']);
        $option->option_value = $version;
        $option->save();
    }
}

if (!function_exists('getAddonCodeCurrentVersion')) {
    function getAddonCodeCurrentVersion($appCode)
    {
        Artisan::call("config:clear");
        if ($appCode == 'SUBSAAS') {
            return config('addon.SUBSAAS.current_version', 0);
        }
    }
}

if (!function_exists('getAddonCodeBuildVersion')) {
    function getAddonCodeBuildVersion($appCode)
    {
        Artisan::call("config:clear");
        if ($appCode == 'SUBSAAS') {
            return config('addon.SUBSAAS.build_version', 0);
        }
    }
}

if (!function_exists('getDomainName')) {
    function getDomainName($url)
    {
        $parseUrl = parse_url(trim($url));
        if (isset($parseUrl['host'])) {
            $host = $parseUrl['host'];
        } else {
            $path = explode('/', $parseUrl['path']);
            $host = $path[0];
        }
        return trim($host);
    }
}

if (!function_exists('updateEnv')) {
    function updateEnv($values)
    {
        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                setEnvironmentValue($envKey, $envValue);
            }
            return true;
        }
    }
}

if (!function_exists('setEnvironmentValue')) {
    function setEnvironmentValue($envKey, $envValue)
    {
        try {
            $envFile = app()->environmentFilePath();
            $str = file_get_contents($envFile);
            $str .= "\n"; // In case the searched variable is in the last line without \n
            $keyPosition = strpos($str, "{$envKey}=");
            if ($keyPosition) {
                if (PHP_OS_FAMILY === 'Windows') {
                    $endOfLinePosition = strpos($str, "\n", $keyPosition);
                } else {
                    $endOfLinePosition = strpos($str, PHP_EOL, $keyPosition);
                }
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                $envValue = str_replace(chr(92), "\\\\", $envValue);
                $envValue = str_replace('"', '\"', $envValue);
                $newLine = "{$envKey}=\"{$envValue}\"";
                if ($oldLine != $newLine) {
                    $str = str_replace($oldLine, $newLine, $str);
                    $str = substr($str, 0, -1);
                    $fp = fopen($envFile, 'w');
                    fwrite($fp, $str);
                    fclose($fp);
                }
            } else if (strtoupper($envKey) == $envKey) {
                $envValue = str_replace(chr(92), "\\\\", $envValue);
                $envValue = str_replace('"', '\"', $envValue);
                $newLine = "{$envKey}=\"{$envValue}\"\n";
                $str .= $newLine;
                $str = substr($str, 0, -1);
                $fp = fopen($envFile, 'w');
                fwrite($fp, $str);
                fclose($fp);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}

if (!function_exists('base64urlEncode')) {
    function base64urlEncode($str)
    {
        return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
    }
}

if (!function_exists('getTimeZone')) {
    function getTimeZone()
    {
        return DateTimeZone::listIdentifiers(
            DateTimeZone::ALL
        );
    }
}

if (!function_exists('getErrorMessage')) {
    function getErrorMessage($e, $customMsg = null)
    {
        if ($customMsg != null) {
            return $customMsg;
        }
        if (env('APP_DEBUG')) {
            return $e->getMessage() . $e->getLine();
        } else {
            return SOMETHING_WENT_WRONG;
        }
    }
}

if (!function_exists('getFileUrl')) {
    function getFileUrl($id = null)
    {

        $file = FileManager::select('path', 'storage_type')->find($id);

        if (!is_null($file)) {
            if (Storage::disk($file->storage_type)->exists($file->path)) {

                if ($file->storage_type == 'public') {
                    return asset('storage/' . $file->path);
                }

                if ($file->storage_type == 'wasabi') {
                    return Storage::disk('wasabi')->url($file->path);
                }


                return Storage::disk($file->storage_type)->url($file->path);
            }
        }

        return asset('assets/images/no-image.jpg');
    }
}

if (!function_exists('emailTemplateStatus')) {
    function emailTemplateStatus($category)
    {
        $status = EmailTemplate::where('category', $category)->where('user_id', auth()->id())->pluck('status')->first();
        if ($status) {
            return $status;
        }
        return DEACTIVATE;
    }
}


if (!function_exists('languageLocale')) {
    function languageLocale($locale)
    {
        $data = Language::where('code', $locale)->first();
        if ($data) {
            return $data->code;
        }
        return 'en';
    }
}


if (!function_exists('getUseCase')) {
    function getUseCase($useCase = [])
    {
        if (in_array("-1", $useCase)) {
            return __("All");
        }
        return count($useCase);
    }
}

function currentCurrency($attribute = '')
{
    $currentCurrency = Currency::where('current_currency', 1)->first();
    if (isset($currentCurrency->{$attribute})) {
        return $currentCurrency->{$attribute};
    }
    return '';
}

function getPairInfo($base_coin_id, $trade_coin_id, $property)
{
    $base_coin = Coin::where('id', $base_coin_id)->first();
    $trade_coin = Coin::where('id', $trade_coin_id)->first();


    if ($property == 'pare_name') {
        return $trade_coin->full_name . '/' . $base_coin->full_name;
    }
    if ($property == 'base_coin_name') {
        return $base_coin->full_name;
    }

    if ($property == 'trade_coin_name') {
        return $trade_coin->full_name;
    }

    if ($property == 'base_coin_price') {
        return convertCurrency(1, $base_coin->coin_type, $trade_coin->coin_type)['price'];
    }

    if ($property == 'trade_coin_price') {
    }
}

function currentCurrencyType()
{
    $currentCurrency = Currency::where('current_currency', 1)->first();
    return $currentCurrency->currency_code;
}

function currentCurrencyIcon()
{
    $currentCurrency = Currency::where('current_currency', 1)->first();
    return $currentCurrency->symbol;
}

function totalBlance()
{

    $userWallet = UserWallet::leftJoin('coins', 'user_wallets.coin_id', '=', 'coins.id')
        ->where('user_wallets.user_id', auth()->id())
        ->select([
            'user_wallets.id as wallet_id',
            'user_wallets.user_id',
            'user_wallets.balance',
            'user_wallets.balance_referral',
            'user_wallets.address',
            'coins.*'
        ])
        ->get();

    $order = 0;
    $blance = 0;

    foreach ($userWallet as $wallet) {
        $blance += convertCurrency($wallet->balance, currentCurrencyType(), $wallet->coin_type)["total"];
    }


    $blance = $blance + $order;

    return $blance;
}

function userWalletById($id = '')
{

    $userWallet = UserWallet::leftJoin('coins', 'user_wallets.coin_id', '=', 'coins.id')
        ->where('user_wallets.id', $id)
        ->select([
            'user_wallets.id as wallet_id',
            'user_wallets.user_id',
            'user_wallets.balance',
            'user_wallets.balance_referral',
            'user_wallets.address',
            'coins.*'
        ])
        ->get();

    return $userWallet;
}



// Convert currency
function convertCurrency($amount, $to = 'USD', $from = 'USD')
{
    //1-BTC-GBP
    try {
        $jsondata = "";

        $coinPriceInCurrency = Setting::where('option_key', 'COIN_PRICE_IN_CURRENCY_FOR' . $from)->first();


        if ($coinPriceInCurrency != null) {

            if ($coinPriceInCurrency->option_value == null) {
                $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
                $json = file_get_contents($url); //,FALSE,$ctx);
                $jsondata = json_decode($json, TRUE);

                $coinPriceInCurrency->option_value = $jsondata[$to];
                $coinPriceInCurrency->save();
            }

            $dateTime = Carbon::now()->addMinute(5);
            $currentTime = $dateTime->format('Y-m-d H:i:s');


            if (($coinPriceInCurrency->option_value != null) && (date('Y-m-d H:i:s', strtotime($coinPriceInCurrency->updated_at)) < $currentTime)) {
                $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
                $json = file_get_contents($url); //,FALSE,$ctx);
                $jsondata = json_decode($json, TRUE);

                $coinPriceInCurrency->option_value = $jsondata[$to];
                $coinPriceInCurrency->save();
            }
        } else {

            $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
            $json = file_get_contents($url); //,FALSE,$ctx);
            $jsondata = json_decode($json, TRUE);

            if ($jsondata != null) {
                $newObj = new Setting();
                $newObj->option_key = 'COIN_PRICE_IN_CURRENCY_FOR' . $from;
                $newObj->option_value = $jsondata[$to];
                $newObj->save();
            }
        }


        return [
            'total' => $amount * getOption('COIN_PRICE_IN_CURRENCY_FOR' . $from),
            'price' => getOption('COIN_PRICE_IN_CURRENCY_FOR' . $from)
        ];
    } catch (\Exception $e) {
        return [
            'total' => 0.00000000,
            'price' => 0.00000000
        ];
    }
}


function convertCurrencySwap($amount, $to = 'USD', $from = 'USD')
{
    try {
        $jsondata = "";

        $coinPriceInCurrency = Setting::where('option_key', 'COIN_PRICE_IN_CURRENCY_FOR' . $from)->first();
        if ($coinPriceInCurrency != null) {

            if ($coinPriceInCurrency->option_value == null) {
                $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
                $json = file_get_contents($url); //,FALSE,$ctx);
                $jsondata = json_decode($json, TRUE);

                $coinPriceInCurrency->option_value = $jsondata[$to];
                $coinPriceInCurrency->save();
            }

            $dateTime = Carbon::now()->addMinute(5);
            $currentTime = $dateTime->format('Y-m-d H:i:s');

            if (($coinPriceInCurrency->option_value != null) && (date('Y-m-d H:i:s', strtotime($coinPriceInCurrency->updated_at)) < $currentTime)) {
                $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
                $json = file_get_contents($url); //,FALSE,$ctx);
                $jsondata = json_decode($json, TRUE);

                $coinPriceInCurrency->option_value = $jsondata[$to];
                $coinPriceInCurrency->save();
            }
        } else {

            $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
            $json = file_get_contents($url); //,FALSE,$ctx);
            $jsondata = json_decode($json, TRUE);

            if ($jsondata != null) {
                $newObj = new Setting();
                $newObj->option_key = 'COIN_PRICE_IN_CURRENCY_FOR' . $from;
                $newObj->option_value = $jsondata[$to];
                $newObj->save();
            }
        }

        return [
            'total' => $amount * getOption('COIN_PRICE_IN_CURRENCY_FOR' . $from),
            'price' => getOption('COIN_PRICE_IN_CURRENCY_FOR' . $from)
        ];
    } catch (\Exception $e) {
        return [
            'total' => 0.00000000,
            'price' => 0.00000000
        ];
    }
}

function random_strings($length_of_string)
{
    $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
    return substr(str_shuffle($str_result), 0, $length_of_string);
}

function broadcastPrivate($eventName, $broadcastData, $userId)
{
    //    $channelName = 'private-'.env("PUSHER_PRIVATE_CHANEL_NAME").'.' . customEncrypt($userId);
    //    dispatch(new BroadcastJob($channelName, $eventName, $broadcastData))->onQueue('broadcast-data');
}

function getUserId()
{
    try {
        return Auth::id();
    } catch (\Exception $e) {
        return 0;
    }
}


if (!function_exists('visual_number_format')) {
    function visual_number_format($value)
    {
        if (is_integer($value)) {
            return number_format($value, 2, '.', '');
        } elseif (is_string($value)) {
            $value = floatval($value);
        }
        $number = explode('.', number_format($value, 10, '.', ''));
        $intVal = (int) $value;
        if ($value > $intVal || $value < 0) {
            $intPart = $number[0];
            $floatPart = substr($number[1], 0, 8);
            $floatPart = rtrim($floatPart, '0');
            if (strlen($floatPart) < 2) {
                $floatPart = substr($number[1], 0, 2);
            }
            return $intPart . '.' . $floatPart;
        }
        return $number[0] . '.' . substr($number[1], 0, 2);
    }
}

function getError($e)
{
    if (env('APP_DEBUG')) {
        return " => " . $e->getMessage();
    }
    return '';
}

function notification($title = null, $body = null, $user_id = null, $link = null)
{
    try {
        $obj = new Notification();
        $obj->title = $title;
        $obj->body = $body;
        $obj->user_id = $user_id;
        $obj->link = $link;
        $obj->save();
        return "notification sent!";
    } catch (\Exception $e) {
        return "something error!";
    }
}

if (!function_exists('get_default_language')) {
    function get_default_language()
    {
        $language = Language::where('default', STATUS_ACTIVE)->first();
        if ($language) {
            $iso_code = $language->iso_code;
            return $iso_code;
        }

        return 'en';
    }
}

if (!function_exists('get_currency_symbol')) {
    function get_currency_symbol()
    {
        $currency = Currency::where('current_currency', STATUS_ACTIVE)->first();
        if ($currency) {
            $symbol = $currency->symbol;
            return $symbol;
        }

        return '';
    }
}

if (!function_exists('get_currency_code')) {
    function get_currency_code()
    {
        $currency = Currency::where('current_currency', STATUS_ACTIVE)->first();
        if ($currency) {
            $currency_code = $currency->currency_code;
            return $currency_code;
        }

        return '';
    }
}

if (!function_exists('get_currency_placement')) {
    function get_currency_placement()
    {
        $currency = Currency::where('current_currency', STATUS_ACTIVE)->first();
        $placement = 'before';
        if ($currency) {
            $placement = $currency->currency_placement;
            return $placement;
        }

        return $placement;
    }
}


function getapisetting($coin_type, $property)
{
    $coin = Coin::join('api_settings', 'coins.id', '=', 'api_settings.coin_id')
        ->where('coins.coin_type', $coin_type)
        ->first([
            'coins.coin_type',
            'api_settings.*'
        ]);

    //    $coin = Coin::where('coin_type',$coin_type)->first();
    return $coin->{$property};
}

if (!function_exists('customNumberFormat')) {
    function customNumberFormat($value)
    {
        $number = explode('.', $value);
        if (!isset($number[1])) {
            return number_format($value, 8, '.', '');
        } else {
            $result = substr($number[1], 0, 8);
            if (strlen($result) < 8) {
                $result = number_format($value, 8, '.', '');
            } else {
                $result = $number[0] . "." . $result;
            }

            return $result;
        }
    }
}


if (!function_exists('calculateFees')) {
    function calculateFees($amount, $feeMethod, $feePercentage, $feeFixed)
    {
        try {
            if ($feeMethod == 1) {
                return customNumberFormat($feeFixed);
            } elseif ($feeMethod == 2) {
                return customNumberFormat(bcdiv(bcmul($feePercentage, $amount), 100));
            } elseif ($feeMethod == 3) {
                return customNumberFormat(bcadd($feeFixed, bcdiv(bcmul($feePercentage, $amount), 100)));
            } else {
                return 0;
            }
        } catch (\Exception $e) {
            return 0;
        }
    }
}

if (!function_exists('excluded_user')) {
    function excluded_user($param = null)
    {
        if ($param == null) {
            return ExcludedUser::all('user_id');
        }
        $userId = ExcludedUser::pluck('user_id')->toArray();

        return $userId;
    }
}

if (!function_exists('trade_max_level')) {
    function trade_max_level()
    {
        return 5;
    }
}

if (!function_exists('getPerCoinRate')) {
    function getPerCoinRate($coin_type)
    {
        return convertCurrencySwap(1, $coin_type, currentCurrency('currency_code'))["price"];
    }
}


if (!function_exists('allsetting')) {
    function allsetting($keys = null)
    {

        if ($keys && is_array($keys)) {
            $settings = Setting::whereIn('option_key', $keys)->pluck('option_value', 'option_key')->toArray();
            $settingsNotFoundInDB = array_fill_keys(array_diff($keys, array_keys($settings)), false);
            if (!empty($settingsNotFoundInDB)) {
                $settings = array_merge($settings, $settingsNotFoundInDB);
            }
            return $settings;
        } elseif ($keys && is_string($keys)) {
            $setting = Setting::where('option_key', $keys)->first();
            return empty($setting) ? false : $setting->value;
        }
        return Setting::pluck('option_value', 'option_key')->toArray();
    }
}


if (!function_exists('createTransaction')) {
    function createTransaction($user_id, $amount, $type, $reference_id, $purpose)
    {
        $transaction = Transaction::create([
            'tnxId' => Str::uuid()->getHex(),
            'user_id' => $user_id,
            'reference_id' => $reference_id,
            'amount' => $amount,
            'purpose' => $purpose,
            'type' => $type
        ]);
    }
}

if (!function_exists('getRandomDecimal')) {
    function getRandomDecimal($min, $max, $probabilityRatio)
    {
        // Calculate the adjusted maximum value based on the probability ratio
        $adjustedMax = $max + ($max - $min) * ($probabilityRatio - 1);

        // Generate a random decimal number within the range
        $randomDecimal = mt_rand($min * 10000, $adjustedMax * 10000) / 10000;

        // Check if the random decimal number needs to be adjusted
        if ($randomDecimal > $max) {
            // Set the number to the maximum value
            $randomDecimal = $max;
        }

        return $randomDecimal;
    }
}

if (!function_exists('getReturnAmountRange')) {
    function getReturnAmountRange($userMining)
    {
        if ($userMining->userPlan->plan->return_type == RETURN_TYPE_RANDOM) {

            if (!is_null($userMining->user_hardware_id)) {
                $allHardware = Hardware::where('status', STATUS_ACTIVE)->orderBy('speed', 'ASC')->get();
                $maxSpeed = $allHardware->max('speed');
                $hardwareRange = [];
                foreach ($allHardware as $hardware) {
                    $hardwareRange[$hardware->id] = ($hardware->speed / $maxSpeed);
                }

                $max = ($userMining->userPlan->plan->max_return_amount_per_day * $hardwareRange[$userMining->userHardware->hardware_id]);
                return ['min' => $userMining->userPlan->plan->min_return_amount_per_day, 'max' => $max];
            }

            return ['min' => $userMining->userPlan->plan->min_return_amount_per_day, 'max' => $userMining->userPlan->plan->min_return_amount_per_day];
        }

        return ['min' => $userMining->userPlan->plan->return_amount_per_day, 'max' => $userMining->userPlan->plan->return_amount_per_day];
    }
}

if (!function_exists('getPlanEarningEstimation')) {
    function getPlanEarningEstimation($plan)
    {
        if ($plan->return_type == RETURN_TYPE_FIXED) {
            return $plan->return_amount_per_day . ' ' . $plan->coin->coin_type;
        } elseif ($plan->return_type == RETURN_TYPE_RANDOM) {
            return $plan->min_return_amount_per_day . ' ' . $plan->coin->coin_type . '-' . $plan->max_return_amount_per_day . ' ' . $plan->coin->coin_type;
        }
    }
}

if (!function_exists('privateUserNotification')) {
    function privateUserNotification()
    {
        return Notification::where('user_id', Auth::id())
            ->where('status', ACTIVE)
            ->orderBy('id', 'DESC')
            ->where('view_status', STATUS_PENDING)
            ->get();
    }
}
if (!function_exists('publicUserNotification')) {
    function publicUserNotification()
    {
        return Notification::where('user_id', null)
            ->where('status', ACTIVE)
            ->orderBy('id', 'DESC')
            ->where('view_status', STATUS_PENDING)
            ->get();
    }
}

function get_clientIp()
{
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
}

function humanFileSize($size, $unit = '')
{
    if ((!$unit && $size >= 1 << 30) || $unit == 'GB') {
        return number_format($size / (1 << 30), 2) . 'GB';
    }

    if ((!$unit && $size >= 1 << 20) || $unit == 'MB') {
        return number_format($size / (1 << 20), 2) . 'MB';
    }

    if ((!$unit && $size >= 1 << 10) || $unit == 'KB') {
        return number_format($size / (1 << 10), 2) . 'KB';
    }

    return number_format($size) . ' bytes';
}

if (!function_exists('getMeta')) {
    function getMeta($slug)
    {
        $metaData = [
            'meta_title' => null,
            'meta_description' => null,
            'meta_keyword' => null,
            'og_image' => null,
        ];

        $meta = Meta::where('slug', $slug)->select([
            'meta_title',
            'meta_description',
            'meta_keyword',
            'og_image',
        ])->first();

        if (!is_null($meta)) {
            $metaData = $meta->toArray();
        } else {
            $meta = Meta::where('slug', 'default')->select([
                'meta_title',
                'meta_description',
                'meta_keyword',
                'og_image',
            ])->first();

            if (!is_null($meta)) {
                $metaData = $meta->toArray();
            }
        }

        $metaData['meta_title'] = $metaData['meta_title'] != NULL ? $metaData['meta_title'] : getOption('app_name');
        $metaData['meta_description'] = $metaData['meta_description'] != NULL ? $metaData['meta_description'] : getOption('app_name');
        $metaData['meta_keyword'] = $metaData['meta_keyword'] != NULL ? $metaData['meta_keyword'] : getOption('app_name');
        $metaData['og_image'] = $metaData['og_image'] != NULL ? getFileUrl($metaData['og_image']) : getFileUrl(getOption('app_logo'));

        return $metaData;
    }
}



function genericEmailNotify($singleData = null, $userData = null, $customData = null, $template = null)
{
    if ($singleData != null) {
        Mail::to($singleData->to)->send(new EmailNotify($singleData, $userData, $customData, $template));
    } elseif ($userData != null) {
        Mail::to($userData->email)->send(new EmailNotify($singleData, $userData, $customData, $template));
    }
}

function getEmailTemplate($category, $property, $link = null, $customData = null, $userData = null)
{
    $data = EmailTemplate::where('slug', $category)->first();
    if ($data && $data != null) {
        if ($property == 'body') {
            $body = $data->{$property};
            foreach (emailTempFields() as $key => $item) {
                if ($key == '{{reset_password_url}}') {
                    $body = str_replace($key, $link, $body);
                } else if ($key == '{{email_verify_url}}') {
                    $body = str_replace($key, $link, $body);
                } else if ($key == '{{order_id}}' && $customData != NULL) {
                    $body = str_replace($key, is_object($customData) ? $customData->order_id : $customData['order_id'], $body);
                } else if ($key == '{{ticket_id}}' && $customData != NULL) {
                    $body = str_replace($key, is_object($customData) ? $customData->ticket_id : $customData['ticket_id'], $body);
                } else if ($key == '{{username}}') {
                    $body = str_replace($key, $userData->name, $body);
                } else if ($key == '{{otp}}') {
                    $body = str_replace($key, $userData->otp, $body);
                } else {
                    $body = str_replace($key, $item, $body);
                }
            }
            return $body;
        } else if ($property == 'subject') {

            $subject = $data->{$property};
            foreach (emailTempFields() as $key => $item) {
                if ($key == '{{customField}}') {
                    $subject = str_replace($key, $customData->customField, $subject);
                }
            }
            return $subject;
        } else {
            return $data->{$property};
        }
    }
    return '';
}

function getEmailTemplateContent($body, $category = null, $customizedFieldsArray = [])
{
    if ($body) {
        $body = $body;
        if ($customizedFieldsArray) {
            foreach (emailTempFields($category) as $key => $item) {
                if (isset($customizedFieldsArray[$key])) {
                    $body = str_replace($key, $customizedFieldsArray[$key], $body);
                }
            }
        }
        return $body;
    }
    return '';
}

function getInvoiceSettingContent($content, $customizedFieldsArray = [])
{
    if ($content) {
        $content = $content;
        if ($customizedFieldsArray) {
            foreach (invoiceSettingFields() as $field) {
                if (isset($customizedFieldsArray[$field])) {
                    $content = str_replace($field, $customizedFieldsArray[$field], $content);
                }
            }
        }
        return $content;
    }
    return '';
}

function gatewaySettings()
{
    return '{"paypal":[{"label":"Url","name":"url","is_show":0},{"label":"Client ID","name":"key","is_show":1},{"label":"Secret","name":"secret","is_show":1}],"stripe":[{"label":"Url","name":"url","is_show":0},{"label":"Secret Key","name":"key","is_show":1},{"label":"Secret Key","name":"secret","is_show":0}],"razorpay":[{"label":"Url","name":"url","is_show":0},{"label":"Key","name":"key","is_show":1},{"label":"Secret","name":"secret","is_show":1}],"instamojo":[{"label":"Url","name":"url","is_show":0},{"label":"Api Key","name":"key","is_show":1},{"label":"Auth Token","name":"secret","is_show":1}],"mollie":[{"label":"Url","name":"url","is_show":0},{"label":"Mollie Key","name":"key","is_show":1},{"label":"Secret","name":"secret","is_show":0}],"paystack":[{"label":"Url","name":"url","is_show":0},{"label":"Public Key","name":"key","is_show":1},{"label":"Secret Key","name":"secret","is_show":0}],"mercadopago":[{"label":"Url","name":"url","is_show":0},{"label":"Client ID","name":"key","is_show":1},{"label":"Client Secret","name":"secret","is_show":1}],"sslcommerz":[{"label":"Url","name":"url","is_show":0},{"label":"Store ID","name":"key","is_show":1},{"label":"Store Password","name":"secret","is_show":1}],"flutterwave":[{"label":"Hash","name":"url","is_show":1},{"label":"Public Key","name":"key","is_show":1},{"label":"Client Secret","name":"secret","is_show":1}],"coinbase":[{"label":"Hash","name":"url","is_show":0},{"label":"API Key","name":"key","is_show":1},{"label":"Client Secret","name":"secret","is_show":0}],"bank":[{"label":"Hash","name":"url","is_show":0},{"label":"API Key","name":"key","is_show":0},{"label":"Client Secret","name":"secret","is_show":0}],"cash":[{"label":"Hash","name":"url","is_show":0},{"label":"API Key","name":"key","is_show":0},{"label":"Client Secret","name":"secret","is_show":0}]}';
}

function replaceBrackets($content, $customizedFieldsArray)
{
    $pattern = '/{{(.*?)}}/';
    $content = preg_replace_callback($pattern, function ($matches) use ($customizedFieldsArray) {
        $field = trim($matches[1]);
        if (array_key_exists($field, $customizedFieldsArray)) {
            return $customizedFieldsArray[$field];
        }
        return $matches[0];
    }, $content);
    return $content;
}

function custom_number_format($value)
{
    if (is_integer($value)) {
        return number_format($value, 8, '.', '');
    } elseif (is_string($value)) {
        $value = floatval($value);
    }
    $number = explode('.', number_format($value, 10, '.', ''));
    return $number[0] . '.' . substr($number[1], 0, 8);
}

if (!function_exists('setCommonNotification')) {
    function setCommonNotification($title, $details, $link = NULL, $userId = NULL)
    {
        try {
            DB::beginTransaction();
            $obj = new Notification();
            $obj->user_id = $userId != NULL ? $userId : NULL;
            $obj->title = $title;
            $obj->body = $details;
            $obj->link = $link != NULL ? $link : NULL;
            $obj->save();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}

if (!function_exists('affiliateCommission')) {
    function affiliateCommission($invoice)
    {
        Log::info('affiliate commission start');
        DB::beginTransaction();
        try {
            $subscription = $invoice->subscription;
            $payment_type = $invoice->is_recurring == ACTIVE ? PAYMENT_TYPE_RECURRING : PAYMENT_TYPE_FIRST;
            if (getOption('affiliate_status') == STATUS_ACTIVE) {
                Log::info('affiliate_status active');
                if (isset($subscription)) {
                    Log::info('subscription data');
                    $affiliateUser = User::query()
                        ->where('created_by', $subscription->user_id)
                        ->where('affiliate_code', $subscription->affiliate_code)
                        ->where('role', USER_ROLE_AFFILIATE)
                        ->where('status', STATUS_ACTIVE)
                        ->first();

                    if (!is_null($affiliateUser)) {
                        Log::info('affiliate user data');
                        $products = ['all', (string) $subscription->product_id];
                        $plans = ['all', (string) $subscription->plan_id];
                        $affiliates = ['all', (string) $affiliateUser->id];

                        $affiliateConfig = AffiliateConfig::query()
                            ->where(function ($q) use ($products) {
                                foreach ($products as $product_id) {
                                    $q->orWhereJsonContains('products', $product_id);
                                }
                            })
                            ->where(function ($q) use ($plans) {
                                foreach ($plans as $plan_id) {
                                    $q->orWhereJsonContains('plans', $plan_id);
                                }
                            })
                            ->where(function ($q) use ($affiliates) {
                                foreach ($affiliates as $affiliate_id) {
                                    $q->orWhereJsonContains('affiliates', $affiliate_id);
                                }
                            })
                            ->where('user_id', $subscription->user_id)
                            ->first();
                        // Log::info($affiliateConfig->toSql());
                        // $affiliateConfig = $affiliateConfig->first();

                        if (!is_null($affiliateConfig)) {
                            Log::info('affiliate config data');
                            if ($payment_type == PAYMENT_TYPE_FIRST) {
                                if ($affiliateConfig->commission_type == COMMISSION_TYPE_FLAT) {
                                    $affiliateCommissionAmount = $affiliateConfig->commission_amount;
                                } else {
                                    $affiliateCommissionAmount = $subscription->amount *  $affiliateConfig->commission_amount * 0.01;
                                }
                            } elseif ($payment_type == PAYMENT_TYPE_RECURRING) {
                                if ($affiliateConfig->recurring_commission_type == COMMISSION_TYPE_FLAT) {
                                    $affiliateCommissionAmount = $affiliateConfig->recurring_commission_amount;
                                } else {
                                    $affiliateCommissionAmount = $subscription->amount *  $affiliateConfig->commission_amount * 0.01;
                                }
                            }

                            if ($affiliateCommissionAmount > 0) {
                                // affiliate history
                                $affiliateHistory = new AffiliateHistory();
                                $affiliateHistory->user_id = $affiliateUser->id;
                                $affiliateHistory->product_id = $subscription->product_id;
                                $affiliateHistory->plan_id = $subscription->plan_id;
                                $affiliateHistory->amount = $affiliateCommissionAmount;
                                $affiliateHistory->save();

                                // affiliate user commission increment
                                $affiliateUser->increment('affiliate_commission_amount', $affiliateCommissionAmount);
                                Log::info('payment increment');
                            }
                        }
                    }
                }
            }

            DB::commit();
            Log::info('affiliate commission end');
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('error' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('userNotification')) {
    function userNotification($type)
    {
        if ($type == 'seen') {
            return Notification::leftJoin('notification_seens', 'notifications.id', '=', 'notification_seens.notification_id')
                ->where(function ($query) {
                    $query->where('notifications.user_id', null)->orWhere('notifications.user_id', Auth::id());
                })
                ->where('notifications.status', ACTIVE)
                ->where('notification_seens.id', '!=', null)
                ->orderBy('id', 'DESC')
                ->get([
                    'notifications.*',
                    'notification_seens.id as seen_id',
                ]);
        } else if ($type == 'unseen') {
            $test = Notification::leftJoin('notification_seens', 'notifications.id', '=', 'notification_seens.notification_id')
                ->where(function ($query) {
                    $query->where('notifications.user_id', null)->orWhere('notifications.user_id', Auth::id());
                })
                ->where('notifications.status', ACTIVE)
                ->where('notification_seens.id', null)
                ->orderBy('id', 'DESC')
                ->get([
                    'notifications.*',
                    'notification_seens.id as seen_id',
                ]);
            return $test;
        } else if ($type == 'seen-unseen') {
            return Notification::leftJoin('notification_seens', 'notifications.id', '=', 'notification_seens.notification_id')
                ->where(function ($query) {
                    $query->where('notifications.user_id', null)->orWhere('notifications.user_id', Auth::id());
                })
                ->where('notifications.status', ACTIVE)
                ->orderBy('id', 'DESC')
                ->get([
                    'notifications.*',
                    'notification_seens.id as seen_id',
                ]);
        }
    }
}

if (!function_exists('getSubText')) {
    function getSubText($html, $limit = 100000)
    {
        return \Illuminate\Support\Str::limit(strip_tags($html), $limit);
    }
}
if (!function_exists('getPaymentType')) {
    function getPaymentType($object)
    {
        return $className = class_basename(get_class($object));
    }
}
if (!function_exists('thousandFormat')) {
    function thousandFormat($number)
    {
        $number = (int) preg_replace('/[^0-9]/', '', $number);
        if ($number >= 1000) {
            $rn = round($number);
            $format_number = number_format($rn);
            $ar_nbr = explode(',', $format_number);
            $x_parts = array('K', 'M', 'B', 'T', 'Q');
            $x_count_parts = count($ar_nbr) - 1;
            $dn = $ar_nbr[0] . ((int) $ar_nbr[1][0] !== 0 ? '.' . $ar_nbr[1][0] : '');
            $dn .= $x_parts[$x_count_parts - 1];

            return $dn;
        }
        return $number;
    }
}

if (!function_exists('getTicketNumber')) {
    function getTicketNumber($eventId, $oldTotal)
    {
        return $eventId . sprintf('%04d', ++$oldTotal);
    }
}

if (!function_exists('userMessageUnseen')) {
    function userMessageUnseen()
    {
        return Chat::where('receiver_id', auth()->id())->where('is_seen', STATUS_PENDING)->count();
    }
}

if (!function_exists('encodeId')) {
    function encodeId($id)
    {
        return encrypt($id);
    }
}
if (!function_exists('decodeId')) {
    function decodeId($id)
    {
        return decrypt($id);
    }
}

if (!function_exists('createWebhookEvent')) {
    function createWebhookEvent($type, $planId, $userId, $requestData)
    {
        try {
            $webhookData = Webhook::where('plan_id', $planId)->first();
            if ($webhookData && $webhookData != null) {
                $reponse = getApiCall($webhookData->webhook_url, $requestData);
                $reponseData = json_decode($reponse);
                $webhookEventObj = new WebhookEvent();
                $webhookEventObj->event_id = 'WHE-' . sprintf('%06d', $planId);
                $webhookEventObj->event_type = $type ?? '';
                $webhookEventObj->user_id = $userId ?? '';
                $webhookEventObj->webhook_id = $webhookData->id;
                $webhookEventObj->product_id = $webhookData->product_id;
                $webhookEventObj->plan_id = $webhookData->plan_id;
                $webhookEventObj->request_data = json_encode($requestData);
                $webhookEventObj->webhook_url = $webhookData->webhook_url;
                $webhookEventObj->response_msg = isset($reponseData->message) ? $reponseData->message : '';
                $webhookEventObj->response_code = isset($reponseData->code) ? $reponseData->code : '';
                $webhookEventObj->response_data = $reponseData != null ? json_encode($reponseData) : '';
                $webhookEventObj->retry_count = 0;
                $webhookEventObj->status = (isset($reponseData->status) && $reponseData->status == true) ? WEBHOOK_EVENT_STATUS_SUCCESS : WEBHOOK_EVENT_STATUS_FAILED;
                $webhookEventObj->save();
                Log::info('Webhook: Event generated successfully: Id-' . $webhookEventObj->id);
            }
        } catch (Exception $exception) {
            Log::info('Webhook Event Create Exception:' . $exception->getMessage());
        }
    }
}


function getApiCall($url, $requestData)
{
    $curl = curl_init();
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url . '?' . http_build_query($requestData),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
        )
    );
    $response = curl_exec($curl);
    curl_close($curl);
    Log::info($response);
    return $response;
    throw new Exception($response->getBody());
}

if (!function_exists('getBeneficiaryDetails')) {
    function getBeneficiaryDetails($item)
    {
        $returnData = '';
        if (!is_null($item)) {
            if ($item->type == BENEFICIARY_BANK) {
                $returnData .= '<span><strong>' . __("Bank Name") . ' : </strong>' . $item->bank_name . '</span><br>
                <span><strong>' . __("Bank Account Number") . ' : </strong>' . $item->bank_account_number . '</span><br>
                <span><strong>' . __("Bank Account Name") . ' : </strong>' . $item->bank_account_name . '</span><br>
                <span><strong>' . __("Routing Number") . ' : </strong>' . $item->bank_routing_number . '</span>';
            } elseif ($item->type == BENEFICIARY_CARD) {
                $returnData .= '<span><strong>' . __("Card Holder Name") . ' : </strong>' . $item->card_holder_name . '</span><br>
                <span><strong>' . __("Card Number") . ' : </strong>' . $item->card_number . '</span><br>
                <span><strong>' . __("Expired Date") . ' : </strong>' . $item->expire_month . '/' . $item->expire_year . '</span>';
            } elseif ($item->type == BENEFICIARY_PAYPAL) {
                $returnData .= '<span><strong>' . __("Paypal Email") . ' : </strong>' . $item->paypal_email . '</span>';
            }
        }

        return $returnData;
    }
}
