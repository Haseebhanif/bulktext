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
        Schema::create('scheduled_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');

            $table->text('message');
            $table->json('variables')->nullable();
            $table->float('total_credits');
            $table->integer('total_contacts')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->string('sender_id')->nullable();
            $table->string('ROUTE_ID')->nullable();
            $table->string('SMS_UID')->nullable();
            $table->enum('status',['complete','pending','archived','draft','processing']);
            $table->boolean('processed')->default(false);
            $table->boolean('optout')->default(true);

            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('user_id');
            $table->date('send_date')->nullable();
            $table->time('send_time')->nullable();

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
        Schema::dropIfExists('scheduled_messages');
    }
};
