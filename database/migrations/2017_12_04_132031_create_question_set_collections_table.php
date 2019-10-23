<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionSetCollectionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('question_set_collections', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 255);
			$table->timestamp('show_on');
			$table->boolean('sponser_status')->default(0);
			$table->string('sponser_image')->nullable();
			$table->string('icon', 300)->nullable();
			$table->string('color', 7)->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('question_set_collections');
	}
}
