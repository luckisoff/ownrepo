<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneratedQuestionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('generated_questions', function(Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('question_id');
			$table->unsignedInteger('user_id');
			$table->string('type');

			$table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('generated_questions');
	}
}
