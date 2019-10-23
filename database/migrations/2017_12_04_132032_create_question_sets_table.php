<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionSetsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('question_sets', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 255);
			$table->boolean('sponser_status')->default(0);
			$table->string('sponser_image')->nullable();
			$table->string('icon', 300)->nullable();
			$table->string('color', 7)->nullable();
			$table->timestamp('start_time')->nullable();
			$table->timestamp('end_time')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('question_sets');
	}
}
