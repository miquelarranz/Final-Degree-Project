<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemAvailabilitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('itemAvailabilities', function(Blueprint $table)
		{
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('enumerations');
			$table->string('availability');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('itemAvailabilities');
	}

}
