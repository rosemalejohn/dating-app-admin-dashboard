<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWebsiteUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('website_id')->unsigned();
            $table->integer('userId')->unsigned();
            $table->unique(['website_id', 'userId']);
            $table->string('fake_message')->nullable();
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
        Schema::drop('website_users');
    }
}
