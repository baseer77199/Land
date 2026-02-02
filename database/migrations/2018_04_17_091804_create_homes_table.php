<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homes', function (Blueprint $table) {
            $table->increments('so_inquiry_hdr_id');
            $table->string('inquiry_no');
            $table->string('inquiry_category');
            $table->string('inquiry_status');
            $table->string('inquiry_type');
            $table->integer('customer_id');
            $table->string('bill_to_location');
            $table->string('ship_to_locaton');
            $table->string('organization_id');
            $table->integer('customer_site_id');
            $table->string('customer_contact_no');

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
        Schema::dropIfExists('homes');
    }
}
