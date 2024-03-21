<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'plans';

    protected $fillable = [
        'product_id',
        'name',
        'code',
        'due_day',
        'price',
        'billing_cycle',
        'shipping_charge',
        'bill',
        'duration',
        'number_of_recurring_cycle',
        'status',
        'free_trail',
        'setup_fee',
    ];
}
