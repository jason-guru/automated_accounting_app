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
            $table->integer('client_id');
            // business Info
            $table->date('business_start_date');
            $table->date('book_start_date')->nullable(true);
            $table->date('year_end_date')->nullable(true);
            $table->string('company_reg_number');
            $table->string('utr_number')->nullable(true);
            // vat_schemes table
            $table->integer('vat_scheme_id');
            // vat_submit_types table
            $table->integer('vat_submit_type_id');
            $table->string('vat_reg_number')->nullable(true);
            $table->date('vat_reg_date')->nullable(true);
            $table->string('social_media')->nullable(true);
            $table->date('last_bookkeeping_done')->nullable(true);
            $table->string('utr')->nullable(true);
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('business_infos');
    }
}
