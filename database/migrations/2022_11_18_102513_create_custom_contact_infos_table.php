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
        Schema::create('custom_contact_infos', function (Blueprint $table) {
            $table->id();
            $table->string('custom_name');
            $table->string('custom_value');
            $table->string('contactable_type');
            $table->unsignedBigInteger('contactable_id');
            $table->unsignedBigInteger('team_id');
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
        Schema::dropIfExists('custom_contact_infos');
    }
};
