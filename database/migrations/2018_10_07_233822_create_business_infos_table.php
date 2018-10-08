<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_infos', function (Blueprint $table) {
            $table->increments('id');
            // business Info
            $table->date('business_start_date');
            $table->date('book_start_date');
            $table->date('year_end_date');
            $table->string('company_reg_number');
            $table->string('utr_number');
            // vat_schemes table
            $table->integer('vat_scheme_id');
            // vat_submit_types table
            $table->integer('vat_submit_type_id');
            $table->string('vat_reg_number');
            $table->date('vat_reg_date');
            $table->string('social_media');
            $table->date('last_bookkeeping_done');
            $table->string('utr');
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
        Schema::dropIfExists('business_infos');
    }
}
