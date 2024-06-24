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
        Schema::create('payment_records', function (Blueprint $table) {
            $table->id();

            $table->string('payment_ref');
            $table->integer('credits');
            $table->integer('amount');
            $table->string('currency');
            $table->string('customer_id');
            $table->string('status');
            $table->string('receipt_url')->nullable();

            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('created_by');

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
        Schema::dropIfExists('payment_records');
    }
};
