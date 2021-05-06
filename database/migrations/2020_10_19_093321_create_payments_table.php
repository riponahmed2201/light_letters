<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->text('name');
            $table->string('address');
            $table->string('city');
            $table->string('zip');
            $table->string('country');
            $table->string('card_number');
            $table->string('card_holder_name');
            $table->date('expire_date');
            $table->string('cvv');
            $table->string('type');
            $table->double('price');
            $table->date('date_of_purchase');
            $table->date('date_of_next_renewal');
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
        Schema::dropIfExists('payments');
    }
}
