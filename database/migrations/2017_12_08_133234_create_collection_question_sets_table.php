<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionQuestionSetsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('collection_question_sets', function(Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('question_set_collection_id');
			$table->unsignedInteger('question_set_id');

			$table->foreign('question_set_collection_id')->references('id')->on('question_set_collections')->onDelete('cascade');
			$table->foreign('question_set_id')->references('id')->on('question_sets')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('collection_question_sets');
	}
}
