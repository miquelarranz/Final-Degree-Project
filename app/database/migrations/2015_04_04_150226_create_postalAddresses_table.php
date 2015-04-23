<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostalAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('postalAddresses', function(Blueprint $table)
		{
			$table->increments('id');
            $table->foreign('id')->references('id')->on('contactPoints');
            $table->string('addressLocality')->nullable();
			$table->string('addressRegion')->nullable();
			$table->string('postalCode')->nullable();
			$table->string('streetAddress')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('postalAddresses');
	}

}
