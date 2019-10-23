<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizParticipationsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('quiz_participations', function(Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('user_id');
			$table->string('token', 10);
			$table->timestamp('selected_at')->nullable();
			$table->string('type');
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users')->table();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('quiz_participations');
	}
}
