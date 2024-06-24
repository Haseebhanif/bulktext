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
        Schema::create('stripe_per_tenants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->string('stripe_token_live')->default(env('STRIPE_KEY'));
            $table->string('stripe_secret_live')->default(env('STRIPE_SECRET'));
            $table->string('stripe_token_test')->default(env('STRIPE_TOKEN_TEST'));
            $table->string('stripe_secret_test')->default(env('STRIPE_TOKEN_TEST'));
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
        Schema::dropIfExists('stripe_per_tenants');
    }
};
