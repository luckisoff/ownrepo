<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisementsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('advertisements', function(Blueprint $table) {
			$table->increments('id');
			$table->string('image', 300)->nullable();
			$table->string('url', 255);
			$table->boolean('active');
			$table->string('type', 4);
			$table->string('category', 255);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('advertisements');
	}
}
