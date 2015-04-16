<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePersonsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('persons', function(Blueprint $table)
		{
			$table->integer('id')->unsigned();;
            $table->foreign('id')->references('id')->on('things');
            $table->date('birthDate');
			$table->string('gender');
			$table->string('familyName');
            $table->integer('nationality')->unsigned();
            $table->foreign('nationality')->references('id')->on('countries');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('persons');
	}

}
