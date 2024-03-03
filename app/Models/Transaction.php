<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'order_id',
        'reference_id',
        'type',
        'tnxId',
        'amount',
        'purpose',
        'payment_time',
        'payment_method',
    ];
}
