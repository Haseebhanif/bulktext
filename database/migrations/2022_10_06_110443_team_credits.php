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
        Schema::create('team_credits', function (Blueprint $table) {
            $table->increments('id');
            //Foreign Key Referencing the id on the users table.
            $table->unsignedBigInteger('team_id')->unsigned()->nullable();
            $table->unsignedBigInteger('company_id')->unsigned();
            $table->integer('amount')->default(0); //credit amount
        });

        Schema::table('team_credits', function($table) {
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('team_credits', function($table) {
            $table->dropForeign(['team_id']);
        });

        Schema::drop('team_credits');
    }
};
