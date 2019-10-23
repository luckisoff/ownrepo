<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaderboardsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('leaderboards', function(Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('week_day');
			$table->unsignedBigInteger('point')->default(0);
			$table->unsignedInteger('count')->default(0);
			$table->unsignedBigInteger('highest_point')->default(0);
			$table->unsignedInteger('highest_point_count')->default(0);
			$table->timestamp('highest_at');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('leaderboards');
	}
}
