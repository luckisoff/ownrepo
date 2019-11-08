<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('ads', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 255);
			$table->string('slug', 255)->nullable();
			$table->string('image', 255)->nullable();
			$table->string('contact', 50)->nullable();
			$table->string('email', 50)->nullable();
			$table->text('description')->nullable();
			$table->string('video_link')->nullable();
			$table->unsignedInteger('visits')->default(0);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('ads');
	}
}
