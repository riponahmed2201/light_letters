<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directmail', function (Blueprint $table) {

            $table->id();
            $table->string('receiver');
            $table->string('sender');
            $table->string('mail_body');
            $table->string('type');
            $table->string('subject')->nullable();
            $table->json('cc')->nullable();
            $table->string('bcc')->nullable();
            $table->string('tag')->nullable();
            $table->integer('group')->nullable();
            $table->json('quick_reply')->nullable();
            $table->json('remainder')->nullable();
            $table->date('deadline')->nullable();
            $table->string('read_status')->nullable();
            $table->string('mail_file')->nullable();
            $table->string('hide_status')->nullable();
            $table->string('reply_status')->nullable();
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
        Schema::dropIfExists('directmail');
    }
}
