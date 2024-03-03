<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Beneficiary extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'beneficiary_name',
        'type',
        'card_number',
        'card_holder_name',
        'expire_month',
        'expire_year',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'bank_routing_number',
        'paypal_email',
        'status'
    ];

    public function withdrawals()
    {
        return $this->hasMany(Withdraw::class);
    }
}
