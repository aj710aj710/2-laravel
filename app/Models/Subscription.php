<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'subscriptions';

    protected $fillable =
    [
        'product_id',
        'plan_id',
        'subscription_id',
        'user_id',
        'customer_id',
        'start_date',
        'end_date',
        'amount',
        'status',
        'due_date',
        'free_trail',
        'setup_fee',
        'billing_cycle',
        'bill',
        'duration',
        'number_of_recurring_cycle',
        'shipping_charge',
        'license',
        'affiliate_code',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function gateway()
    {
        return $this->belongsTo(Gateway::class, 'gateway_id', 'id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
