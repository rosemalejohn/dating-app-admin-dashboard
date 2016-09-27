<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAffiliateContractTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_contract_terms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('affiliate_id')->unsigned();
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
            $table->decimal('chargeback_rate', 8, 2)->nullable()->default(0);
            $table->decimal('minimum_payout', 8, 2)->nullable()->default(0);
            $table->string('chargeback_fee')->nullable();
            $table->string('billing_period')->nullable();
            $table->double('rolling_reserve')->nullable();
            $table->string('rolling_reserve_period')->nullable();
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
        Schema::drop('affiliate_contract_terms');
    }
}
