<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrizesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('prizes', function(Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('sponsor_id');
			$table->unsignedInteger('week_day');
			$table->unsignedInteger('position')->default(1);
			$table->text('description');
			$table->timestamps();

			$table->foreign('sponsor_id')->references('id')->on('sponsors')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('prizes');
	}
}
