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
        Schema::create('contact_imports', function (Blueprint $table) {
            $table->id();
            $table->string('file_name')->nullable();
            $table->boolean('complete')->default(false);
            $table->unsignedBigInteger('team_id');
            $table->json('errors')->nullable();
            $table->bigInteger('error_count')->nullable();
            $table->bigInteger('success_count')->nullable();
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
        Schema::dropIfExists('contact_imports');
    }
};
