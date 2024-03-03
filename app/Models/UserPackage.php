<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPackage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'user_id',
        'package_id',
        'order_id',
        'customer_limit',
        'product_limit',
        'subscription_limit',
        'monthly_price',
        'yearly_price',
        'start_date',
        'end_date',
        'is_trail',
        'status'
    ];
}
