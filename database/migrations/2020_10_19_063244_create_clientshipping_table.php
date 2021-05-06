<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientshippingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientshipping', function (Blueprint $table) {
            $table->integer('id');
            $table->string('billing_id');
            $table->text('s_name');
            $table->string('s_address');
            $table->text('s_city');
            $table->integer('s_phone');
            $table->text('s_country');

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
        Schema::dropIfExists('clientshipping');
    }
}
