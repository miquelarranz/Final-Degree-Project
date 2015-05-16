<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubscribedEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subscribedEvents', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('name');
            $table->string('url')->nullable();
            $table->string('description')->nullable();
            $table->dateTime('startDate')->nullable();
            $table->string('address')->nullable();
            $table->string('type')->nullable();
            $table->string('city')->nullable();
            $table->integer('user')->unsigned();
            $table->foreign('user')->references('id')->on('users');
            $table->integer('associatedEvent');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('subscribedEvents');
	}

}
