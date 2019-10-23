<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFastestFingerFirstOptionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('fastest_finger_first_options', function(Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('question_id');
			$table->string('option', 255);
			$table->unsignedTinyInteger('order');
			$table->timestamps();

			$table->foreign('question_id')->references('id')->on('fastest_finger_first_questions')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('fastest_finger_first_options');
	}
}
