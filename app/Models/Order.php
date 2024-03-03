<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use MercadoPago\Invoice;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable =
    [
        'user_id',
        'transaction_id',
        'transaction_amount',
        'total',
        'tax_percentage',
        'tax_amount',
        'system_currency',
        'subtotal',
        'subscription_id',
        'shipping_cost',
        'setup_fees',
        'product_id',
        'platform_charge',
        'plan_id',
        'payment_status',
        'payment_id',
        'order_number',
        'order_id',
        'invoice_id',
        'gateway_id',
        'gateway_currency',
        'discount_type',
        'discount',
        'delivery_status',
        'customer_id',
        'conversion_rate',
        'bank_id',
        'bank_deposit_slip_id',
        'bank_deposit_by',
        'amount',
    ];

    public function gateway()
    {
        return $this->belongsTo(Gateway::class, 'gateway_id');
    }
}
