<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionConversionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('option_conversions', function(Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('option_id');
			$table->unsignedInteger('language_id');
			$table->string('name', 255);
			$table->timestamps();

			$table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
			$table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('option_conversions');
	}
}
