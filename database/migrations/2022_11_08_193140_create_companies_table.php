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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->enum('status',['active','pending','suspended','deleted'])->default('pending');
            $table->unsignedBigInteger('creator_id');
            $table->float('message_rate')->default(1.0);
            $table->float('credit_rate',8,4)->default(0.035);
            $table->unsignedBigInteger('tenant_id');

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
        Schema::dropIfExists('companies');
    }
};
