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
        Schema::table('companies', function (Blueprint $table) {

            $table->string('company_no')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('post_code')->nullable();
            $table->string('company_vat')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {

            $table->dropColumn('company_no');
            $table->dropColumn('address1');
            $table->dropColumn('address2');
            $table->dropColumn('post_code');
            $table->dropColumn('company_vat');
            $table->dropColumn('company_phone');
            $table->dropColumn('company_email');
        });
    }
};
