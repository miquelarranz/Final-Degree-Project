<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateThingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('things', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('additionalType');
			$table->string('alternateName');
			$table->string('description');
			$table->string('name');
			$table->string('image');
			$table->string('sameAs');
			$table->string('url');
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
		Schema::drop('things');
	}

}
