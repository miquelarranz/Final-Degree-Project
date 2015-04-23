<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOpenDataSourcesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('openDataSources', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('url');
			$table->string('description');
			$table->integer('city')->unsigned();
            $table->foreign('city')->references('id')->on('openDataCities');
            $table->string('extension');
			$table->dateTime('lastUpdateDate');
			$table->dateTime('updateInterval');
			$table->string('configurationFilePath');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('openDataSources');
	}

}
