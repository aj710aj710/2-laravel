<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }
    public function license()
    {
        return $this->hasMany(License::class);
    }

    public function taxProduct()
    {
        return $this->hasMany(TaxSetting::class);
    }
}
