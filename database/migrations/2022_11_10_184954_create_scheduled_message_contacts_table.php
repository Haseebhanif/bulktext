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
        Schema::create('scheduled_message_contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scheduled_message_id');
            $table->text('message_sent');
            $table->integer('sms_qty');
            $table->float('sms_rate');
            $table->integer('credits_used');
            $table->string('country_code');
            $table->string('number');
            //CM unique id for query Delivery reports
            $table->string('SMS_UID')->nullable();
            $table->string('RESULT_CODE')->nullable();
            $table->string('RESULT_DESC')->nullable();
            $table->boolean('sent')->default(false);
            //CM ready for action flow api on contact responses.
            $table->boolean('response')->default(false);


            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('company_id');
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
        Schema::dropIfExists('scheduled_message_contacts');
    }
};
