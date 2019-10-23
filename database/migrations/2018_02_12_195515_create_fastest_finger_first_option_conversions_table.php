<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFastestFingerFirstOptionConversionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('fastest_finger_first_option_conversions', function(Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('option_id');
			$table->unsignedInteger('language_id');
			$table->string('option', 255);
			$table->timestamps();

			$table->foreign('option_id')->references('id')->on('fastest_finger_first_options')->onDelete('cascade');
			$table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('fastest_finger_first_option_conversions');
	}
}
