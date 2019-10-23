<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDifficultyLevelsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('difficulty_levels', function(Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('level');
			$table->unsignedInteger('duration')->nullable();
			$table->unsignedInteger('price');
			$table->unsignedInteger('point')->default(0);
			$table->string('sponser_image', 500)->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('difficulty_levels');
	}
}
