<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArdiscontshdrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ardiscontshdrs', function (Blueprint $table) {
            $table->increments('ar_discount_hdr_id');
            $table->string('discount_name');
            $table->string('discount_applylevel');
            $table->integer('discount_currency_id');
            $table->string('default_discount_amount');
            $table->timestamps('start_date');
            $table->timestamps('end_date');
            $table->string('active');
            $table->string('remarks');
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
        Schema::dropIfExists('ardiscontshdrs');
    }
}
