<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSponsorIdToQuestionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('questions', function(Blueprint $table) {
			$table->unsignedInteger('sponsor_id')->after('category_id')->nullable();

			$table->foreign('sponsor_id')->references('id')->on('sponsors')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('questions', function(Blueprint $table) {
			$table->dropForeign(['sponsor_id']);
			$table->dropColumn('sponsor_id');
		});
	}
}
