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
        Schema::table('gateways', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id')->nullable();
        });

        Schema::table('gateway_currencies', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id')->nullable();
        });

        Schema::table('banks', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gateways', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::table('gateway_currencies', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::table('banks', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
