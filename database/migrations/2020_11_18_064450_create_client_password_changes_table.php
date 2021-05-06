<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientPasswordChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_password_changes', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
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
        Schema::dropIfExists('client_password_changes');
    }
}
