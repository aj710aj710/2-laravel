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
        Schema::create('webhook_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_id');
            $table->tinyInteger('event_type');
            $table->integer('user_id');
            $table->integer('webhook_id');
            $table->integer('product_id');
            $table->integer('plan_id');
            $table->longText('request_data');
            $table->string('webhook_url');
            $table->string('response_msg');
            $table->string('response_code');
            $table->integer('retry_count');
            $table->text('response_data')->nullable();
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
        Schema::dropIfExists('webhook_events');
    }
};
