<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOtherFieldsToUsersTable extends Migration {
	public function up() {
		Schema::table('users', function(Blueprint $table) {
			$table->string('social_id')->unique()->nullable();
			$table->string('social_name', 8)->nullable();
			$table->string('address')->nullable();
			$table->string('phone')->nullable();
			$table->unsignedTinyInteger('age')->nullable();
			$table->enum('gender', ['M', 'F', 'O'])->default('M');
			$table->timestamp('dob')->nullable();
			$table->string('image')->nullable();
			$table->longText('about')->nullable();
			$table->string('facebook_url', 300)->nullable();
			$table->string('twitter_url', 300)->nullable();
			$table->boolean('verified')->default(0);
			$table->string('email_token', 11)->nullable();
			$table->string('access_token', 1500)->nullable();
			$table->string('refresh_token', 1500)->nullable();
			$table->timestamp('last_login_at')->nullable();
		});
	}

	public function down() {
		Schema::table('users', function(Blueprint $table) {
			//
		});
	}
}
