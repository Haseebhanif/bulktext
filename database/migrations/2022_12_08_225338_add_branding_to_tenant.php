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
        Schema::table('tenants', function (Blueprint $table) {
            $table->text('logo')->nullable();
            $table->text('background')->nullable();
            $table->text('login')->nullable();
            $table->text('register')->nullable();
            $table->string('colour1')->nullable();
            $table->string('colour2')->nullable();

            $table->string('company_name')->nullable();
            $table->string('company_no')->nullable();
            $table->string('address1')->nullable();
            $table->string('post_code')->nullable();
            $table->string('company_vat')->nullable();



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn('logo');
            $table->dropColumn('background');
            $table->dropColumn('login');
            $table->dropColumn('register');
            $table->dropColumn('colour1');
            $table->dropColumn('colour2');

            $table->dropColumn('company_name');
            $table->dropColumn('company_no');
            $table->dropColumn('address1');
            $table->dropColumn('post_code');
            $table->dropColumn('company_vat');

        });
    }
};
