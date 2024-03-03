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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->tinyInteger('bank_id')->nullable();
            $table->bigInteger('plan_id')->nullable();
            $table->bigInteger('invoice_id')->nullable();
            $table->bigInteger('gateway_id')->nullable();
            $table->bigInteger('subscription_id')->nullable();
            $table->string('order_id')->nullable();
            $table->decimal('amount', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->tinyInteger('discount_type')->default(0);
            $table->decimal('shipping_cost', 12, 2)->default(0);
            $table->decimal('setup_fees', 12, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->integer('tax_type')->default(0);
            $table->decimal('conversion_rate', 12, 2)->default(0);
            $table->decimal('platform_charge', 12, 2)->default(0);
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->decimal('transaction_amount', 12, 2)->default(0);
            $table->string('order_number')->nullable();
            $table->tinyInteger('payment_status')->default(1);
            $table->tinyInteger('delivery_status')->default(1);
            $table->string('system_currency')->nullable();
            $table->string('gateway_currency')->nullable();
            $table->string('bank_deposit_by')->nullable();
            $table->string('bank_deposit_slip_id')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
