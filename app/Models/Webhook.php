<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Webhook extends Model
{
    use HasFactory, SoftDeletes;

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
