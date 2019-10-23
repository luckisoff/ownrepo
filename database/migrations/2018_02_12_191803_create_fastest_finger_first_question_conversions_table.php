<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFastestFingerFirstQuestionConversionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('fastest_finger_first_question_conversions', function(Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('question_id');
			$table->unsignedInteger('language_id');
			$table->string('question', 255);
			$table->timestamps();

			$table->foreign('question_id')->references('id')->on('fastest_finger_first_questions')->onDelete('cascade');
			$table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('fastest_finger_first_question_conversions');
	}
}
