<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReplymailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replymail', function (Blueprint $table) {
            $table->id();
            $table->integer('direct_mail_id');
            $table->string('receiver');
            $table->string('sender');
            $table->string('mail_body')->nullable();
            $table->string('type');
            $table->string('subject')->nullable();
            $table->json('cc')->nullable();
            $table->string('bcc')->nullable();
            $table->string('tag')->nullable();
            $table->integer('group')->nullable();
            $table->string('read_status')->nullable();
            $table->string('mail_file')->nullable();
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
        Schema::dropIfExists('replymail');
    }
}
