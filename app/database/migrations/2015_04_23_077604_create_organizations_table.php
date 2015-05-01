<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrganizationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('organizations', function(Blueprint $table)
		{
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('things');
			$table->string('email')->nullable();
            $table->integer('event')->unsigned()->nullable();
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
		Schema::drop('organizations');
	}

}
