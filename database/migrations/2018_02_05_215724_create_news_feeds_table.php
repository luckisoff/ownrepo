<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsFeedsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('news_feeds', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 255);
			$table->string('slug', 300);
			$table->longText('description')->nullable();
			$table->string('youtube_url')->nullable();
			$table->enum('type', ['news', 'video', 'gallery'])->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('news_feeds');
	}
}
