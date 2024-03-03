<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('name');
            $table->string('code');
            $table->tinyInteger('discount_type')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('redemption_type')->default(0);
            $table->integer('product_plan')->default(0);
            $table->date('valid_date');
            $table->integer('maximum_redemption')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->integer('user_id')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
};
