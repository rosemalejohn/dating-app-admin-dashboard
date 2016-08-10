<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserSentMessageRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sent_message_replies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_sent_message_id')->unsigned();
            $table->foreign('user_sent_message_id')->references('id')->on('user_sent_messages')->onDelete('cascade');
            $table->integer('message_id')->unsigned();
            $table->unique(['user_sent_message_id', 'message_id']);
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
        Schema::drop('user_sent_message_replies');
    }
}
