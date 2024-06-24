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
        Schema::table('stripe_per_tenants', function (Blueprint $table) {
            $table->text('stripe_token_live')->default(env('STRIPE_KEY'))->change();
            $table->text('stripe_secret_live')->default(env('STRIPE_SECRET'))->change();
            $table->text('stripe_token_test')->default(env('STRIPE_TOKEN_TEST'))->change();
            $table->text('stripe_secret_test')->default(env('STRIPE_TOKEN_TEST'))->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stripe_per_tenants', function (Blueprint $table) {
            //
        });
    }
};
