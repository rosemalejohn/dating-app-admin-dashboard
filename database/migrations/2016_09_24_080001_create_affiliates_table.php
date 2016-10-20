<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAffiliatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('company');
            $table->date('birthday')->nullable();
            $table->string('email')->unique();
            $table->string('address')->nullbale();
            $table->string('country')->nullable();
            $table->string('phone')->nullable();
            $table->string('skype')->nullable();
            $table->string('payment')->nullable();
            $table->string('currency')->nullable();
            $table->decimal('salary', 8, 2);
            $table->string('password');
            $table->string('qr_code')->nullable();
            $table->longtext('photo')->nullable();
            $table->integer('upline_id')->unsigned();
            $table->rememberToken();
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
        Schema::drop('affiliates');
    }
}
