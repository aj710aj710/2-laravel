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
        Schema::create('invoice_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->tinyInteger('type')->default(INVOICE_SETTING_TYPE_ORDER);
            $table->unsignedBigInteger('logo')->nullable();
            $table->string('title')->nullable();
            $table->text('company_info')->nullable();
            $table->string('prefix')->nullable();
            $table->text('info_one')->nullable();
            $table->text('info_two')->nullable();
            $table->text('info_three')->nullable();
            $table->text('footer_text')->nullable();
            $table->text('column')->nullable();
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
        Schema::dropIfExists('invoice_settings');
    }
};
