<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGeoCoordinatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('geoCoordinates', function(Blueprint $table)
		{
			$table->increments('id');
            $table->foreign('id')->references('id')->on('structuredValues');
            $table->double('latitude');
			$table->double('longitude');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('geoCoordinates');
	}

}
