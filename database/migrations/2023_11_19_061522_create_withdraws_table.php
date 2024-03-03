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
        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('beneficiary_id')->nullable();
            $table->string('tnxId', 80);
            $table->decimal('amount', 12, 2)->default('0.00');
            $table->string('payment_method', 100)->nullable();
            $table->mediumText('note')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=pending, 1=complete, 2=rejected');
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
        Schema::dropIfExists('withdraws');
    }
};
