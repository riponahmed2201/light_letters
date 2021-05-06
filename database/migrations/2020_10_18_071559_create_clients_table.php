<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateclientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('email');
            $table->string('password');
            $table->string('profile_picture')->default('default_client.png');
            $table->string('status');
            $table->string('company')->nullable();
            $table->string('activation_status');
            $table->string('admin_id')->nullable();
            $table->string('role')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_reg_no')->nullable();
            $table->string('company_bit_no')->nullable();
            $table->string('company_contact_person')->nullable();
            $table->string('contact_person_designation')->nullable();
            $table->string('number_of_employee')->nullable();
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
        Schema::dropIfExists('client');
    }
}
