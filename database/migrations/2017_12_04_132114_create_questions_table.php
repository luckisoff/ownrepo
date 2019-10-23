<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('questions', function(Blueprint $table) {
			$table->increments('id');
			// when online we don't need difficulty_level_id
			$table->unsignedInteger('difficulty_level_id')->nullable();
			$table->unsignedInteger('category_id')->nullable();
			// when offline we don't need difficulty_set_id
			$table->unsignedInteger('question_set_id')->nullable();
			$table->string('name', 1000);
			$table->string('type', 7);
			$table->string('file', 999)->nullable();
			$table->boolean('online')->default(0);
			$table->boolean('question_of_the_day')->default(0);
			$table->timestamps();

			$table->foreign('difficulty_level_id')->references('id')->on('difficulty_levels')->onDelete('cascade');
			$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
			$table->foreign('question_set_id')->references('id')->on('question_sets')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('questions');
	}
}
