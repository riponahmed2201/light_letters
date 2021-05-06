<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_changes', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('email');
            $table->string('request_status')->nullable();
            $table->string('verification')->nullable();
            $table->string('confirmation')->nullable();
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
        Schema::dropIfExists('password_changes');
    }
}
