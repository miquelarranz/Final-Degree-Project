<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function(Blueprint $table)
		{
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('things');
            $table->dateTime('doorTime')->nullable();
			$table->time('duration')->nullable();
			$table->dateTime('startDate')->nullable();
			$table->dateTime('endDate')->nullable();
			$table->text('type')->nullable();
			$table->string('typicalAgeRange')->nullable();
            $table->integer('eventStatus')->unsigned()->default(197);
            $table->foreign('eventStatus')->references('id')->on('eventStatusTypes');
            $table->integer('location')->unsigned()->nullable();
            $table->foreign('location')->references('id')->on('places');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('events');
	}

}
