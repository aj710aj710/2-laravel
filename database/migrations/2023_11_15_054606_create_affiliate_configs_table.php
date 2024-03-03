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
        Schema::create('affiliate_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('title');
            $table->text('products')->nullable();
            $table->text('plans')->nullable();
            $table->text('affiliates')->nullable();
            $table->tinyInteger('commission_type')->default(COMMISSION_TYPE_FLAT);
            $table->decimal('commission_amount', 12, 2)->default(0);
            $table->tinyInteger('recurring_commission_type')->default(COMMISSION_TYPE_FLAT);
            $table->decimal('recurring_commission_amount', 12, 2)->default(0);
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
        Schema::dropIfExists('affiliate_configs');
    }
};
