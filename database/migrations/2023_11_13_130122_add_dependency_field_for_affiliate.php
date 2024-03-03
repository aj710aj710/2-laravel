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
        Schema::table('users', function (Blueprint $table) {
            $table->string('affiliate_code')->nullable();
            $table->decimal('affiliate_commission_amount', 12, 2)->default(0);
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('affiliate_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('affiliate_code');
            $table->dropColumn('affiliate_commission_amount');
        });
        
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('affiliate_code');
        });
    }
};
