<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventStatusTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('eventStatusTypes', function(Blueprint $table)
		{
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('enumerations');
			$table->string('status');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('eventStatusTypes');
	}

}
