<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('offers', function(Blueprint $table)
		{
            $table->integer('id')->unsigned();;
            $table->foreign('id')->references('id')->on('intangibles');
			$table->double('price')->nullable();
			$table->string('priceCurrency')->nullable();
			$table->integer('availability')->unsigned();
            $table->foreign('availability')->references('id')->on('itemAvailabilities');
			$table->integer('event')->unsigned();
            $table->foreign('event')->references('id')->on('events');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('offers');
	}

}
