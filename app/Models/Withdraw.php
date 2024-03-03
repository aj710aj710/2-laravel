<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Withdraw extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'beneficiary_id',
        'tnxId',
        'amount',
        'payment_method',
        'note',
        'status',
    ];

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class);
    }

   public function user()
    {
        return $this->belongsTo(User::class);
    }
}
