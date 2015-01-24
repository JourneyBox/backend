<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('display_name');
			$table->string('dropbox_user_id')->unique()->nullable();
			$table->string('dropbox_access_token')->nullable();
			$table->string('dropbox_display_name')->nullable();
			$table->string('eventbrite_access_token')->nullable();
			$table->timestamps();
            $table->rememberToken();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
