<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table){
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('password');
            $table->string('profile_picture')->default('default_customer.png')->nullable();
            $table->string('id_type')->default('no_data')->nullable();
            $table->string('nid')->default('no_data')->nullable();
            $table->string('ra_type')->default('no_data')->nullable();
            $table->string('ra_file')->default('no_data')->nullable();
            $table->string('phone')->nullable();
            $table->string('status')->default('Verification pending')->nullable();
            $table->string('comment')->default('Not verified yet')->nullable();
            $table->string('group')->nullable();
            $table->string('tag')->nullable();
            $table->string('road')->nullable();
            $table->string('house')->nullable();
            $table->string('city')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
