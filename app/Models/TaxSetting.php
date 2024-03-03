<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaxSetting extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'tax_rule_name',
        'user_id',
        'product_id',
        'plan_id',
        'tax_amount',
        'tax_type',
        'status'
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
