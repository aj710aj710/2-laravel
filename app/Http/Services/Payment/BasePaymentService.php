<?php


namespace App\Http\Services\Payment;

use App\Models\Gateway;
use App\Models\GatewayCurrency;
use App\Models\User;

class BasePaymentService
{
    public $paymentMethod;
    public $callbackUrl;
    public $currency;
    public $gateway;
    public $gatewayCurrency;
    public $amount;
    public $type;
    public $user_id;

    public function __construct($method, $object)
    {
        if (isset($object['id'])) {
            $this->callbackUrl = $object['callback_url'] . '?id=' . $object['id'];
        }

        if (isset($object['currency'])) {
            $this->currency = $object['currency'];
        }

        if (isset($object['type'])) {
            $this->type = $object['type'];
        }

        if (isset($object['user_id'])) {
            $this->user_id = $object['user_id'];
        }

        if ($this->type == 'subscription') {
            $this->user_id = User::where('role', USER_ROLE_ADMIN)->first()->id;
        }


        $this->paymentMethod = $method;

        $this->gateway = Gateway::where(['user_id' => $this->user_id, 'slug' => $this->paymentMethod])->first();

        if ($this->gateway) {
            $this->gatewayCurrency = GatewayCurrency::where(['user_id' => $this->user_id, 'gateway_id' => $this->gateway->id, 'currency' => $this->currency])->firstOrFail();
        }
    }

    public function calculateAmount($amount)
    {
        return $this->numberParser($this->gatewayCurrency->conversion_rate) * $this->numberParser($amount);
    }

    public function setAmount($amount)
    {
        $this->amount = $this->calculateAmount($amount);
    }

    function numberParser($value)
    {
        return (float) str_replace(',', '', number_format(($value), 2));
    }
}
