<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangingIndexesToSubscribedEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('subscribedEvents', function(Blueprint $table)
		{
            $table->dropForeign('subscribedevents_user_foreign');
            $table->foreign('user')
                ->references('id')->on('users')
                ->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('subscribedEvents', function(Blueprint $table)
		{
			$table->dropColumn('remember_token');
		});
	}

}
