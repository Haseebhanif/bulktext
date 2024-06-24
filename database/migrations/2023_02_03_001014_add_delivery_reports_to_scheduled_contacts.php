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
        Schema::table('scheduled_message_contacts', function (Blueprint $table) {
            $table->string('dr_type')->nullable();
            $table->json('dr_response')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scheduled_message_contacts', function (Blueprint $table) {
            $table->dropColumn('dr_type');
            $table->dropColumn('dr_response');
        });
    }
};
