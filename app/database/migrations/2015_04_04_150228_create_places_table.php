<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlacesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('places', function(Blueprint $table)
		{
			$table->increments('id');
            $table->foreign('id')->references('id')->on('things');
            $table->integer('address')->unsigned()->nullable();
            $table->foreign('address')->references('id')->on('postalAddresses');
			$table->integer('geo')->unsigned()->nullable();
            $table->foreign('geo')->references('id')->on('geoCoordinates');
            $table->integer('containedIn')->unsigned()->nullable();
            $table->foreign('containedIn')->references('id')->on('places');
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
		Schema::drop('places');
	}

}
