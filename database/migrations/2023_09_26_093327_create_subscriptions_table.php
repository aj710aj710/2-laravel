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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('plan_id');
            $table->string('subscription_id');
            $table->string('license')->nullable();
            $table->integer('user_id');
            $table->integer('customer_id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('due_day')->default(0);
            $table->decimal('amount', 12, 2);
            $table->integer('free_trail')->default(0);
            $table->decimal('setup_fee',9,2)->default(0.00);
            $table->tinyInteger('billing_cycle')->default(0);
            $table->integer('bill')->default(1);
            $table->tinyInteger('duration')->default(0);
            $table->integer('number_of_recurring_cycle')->default(0);
            $table->decimal('shipping_charge', 12, 2)->default(0);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('subscriptions');
    }
};
