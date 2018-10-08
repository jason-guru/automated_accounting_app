<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_number');
            $table->string('company_name');
            $table->boolean('company_type_id');
            $table->date('accounts_next_due');
            $table->boolean('accounts_overdue');
            // address
            $table->string('address_line_1');
            $table->string('address_line_2');
            $table->integer('postcode');
            $table->string('city');
            $table->string('county');
            $table->string('country_id');
            // contact info
            $table->string('phone');
            $table->string('website');
            $table->string('email');
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
}
