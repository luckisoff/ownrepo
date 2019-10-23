<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionConversionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('question_conversions', function(Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('question_id');
			$table->unsignedInteger('language_id');
			$table->string('name', 255);
			$table->timestamps();

			$table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
			$table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('question_conversions');
	}
}
