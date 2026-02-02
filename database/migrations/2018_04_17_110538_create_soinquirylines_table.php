<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoinquirylinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soinquirylines', function (Blueprint $table) {
            $table->increments('so_inquiry_lines_id');
            $table->integer('so_inquiry_hdr_id');
            $table->integer('line_no');
            $table->string('product_id');
            $table->string('uom_code_id');
            $table->integer('required_qty');
            $table->timestamps('need_by_date');
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
        Schema::dropIfExists('soinquirylines');
    }
}
