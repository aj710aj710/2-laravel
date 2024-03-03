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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('name');
            $table->string('code');
            $table->integer('due_day');
            $table->decimal('price',9,2);
            $table->tinyInteger('billing_cycle')->default(0);
            $table->unsignedBigInteger('shipping_charge')->default(0);
            $table->integer('bill')->default(0);
            $table->tinyInteger('duration')->default(0);
            $table->integer('number_of_recurring_cycle')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->integer('free_trail')->default(0);
            $table->decimal('setup_fee',9,2)->default(0.00);
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
        Schema::dropIfExists('plans');
    }
};
