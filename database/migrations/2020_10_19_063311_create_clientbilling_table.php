<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientbillingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('clientbilling', function (Blueprint $table) {
            $table->string('id');
            $table->integer('client_id');
            $table->text('b_name');
            $table->string('b_address');
            $table->text('b_city');
            $table->integer('b_phone');
            $table->text('b_country');
            $table->string('package');
            $table->string('description');

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
        Schema::dropIfExists('clientbilling');
    }
}
