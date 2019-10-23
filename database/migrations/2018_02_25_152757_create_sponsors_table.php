<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSponsorsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('sponsors', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 255);
			$table->string('image', 300)->nullable();
			$table->string('background_image', 300)->nullable();
			$table->string('ad_image', 300)->nullable();
			$table->string('facebook_id')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('sponsors');
	}
}
