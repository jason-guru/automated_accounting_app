<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_number');
            $table->string('company_name');
            $table->boolean('company_type_id');
            $table->date('accounts_next_due');
            $table->boolean('accounts_overdue');
            // address
            $table->string('address_line_1')->nullable(true);
            $table->string('address_line_2')->nullable(true);
            $table->string('postcode')->nullable(true);
            $table->string('city')->nullable(true);
            $table->string('county')->nullable(true);
            $table->string('country_id');
            // contact info
            $table->string('phone')->nullable(true);
            $table->string('website')->nullable(true);
            $table->string('email')->nullable(true);
            $table->boolean('is_active')->default(true);
            $table->boolean('remind')->default(true);
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
        Schema::dropIfExists('clients');
    }
}
