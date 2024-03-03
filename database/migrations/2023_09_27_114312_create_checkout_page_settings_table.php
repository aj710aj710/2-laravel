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
        Schema::create('checkout_page_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('image')->nullable();
            $table->string('title')->nullable();
            $table->string('text_size')->nullable();
            $table->string('text_color')->nullable();
            $table->longText('basic_info')->nullable();
            $table->string('basic_first_name')->nullable();
            $table->string('basic_last_name')->nullable();
            $table->string('basic_phone')->nullable();
            $table->string('basic_email')->nullable();
            $table->string('basic_company')->nullable();
            $table->longText('billing_info')->nullable();
            $table->string('billing_first_name')->nullable();
            $table->string('billing_last_name')->nullable();
            $table->string('billing_email')->nullable();
            $table->string('billing_phone')->nullable();
            $table->string('billing_zip_code')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_country')->nullable();
            $table->longText('shipping_info')->nullable();
            $table->longText('shipping_first_name')->nullable();
            $table->longText('shipping_last_name')->nullable();
            $table->longText('shipping_email')->nullable();
            $table->longText('shipping_phone')->nullable();
            $table->longText('shipping_zip_code')->nullable();
            $table->longText('shipping_address')->nullable();
            $table->longText('shipping_city')->nullable();
            $table->longText('shipping_state')->nullable();
            $table->longText('shipping_country')->nullable();
            $table->tinyInteger('shipping_method')->nullable(SHIPPING_METHOD_FREE);
            $table->longText('payment')->nullable();
            $table->tinyInteger('status')->default(CHECKOUT_PAGE_SETTING_STATUS_PENDING);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkout_page_settings');
    }
};
