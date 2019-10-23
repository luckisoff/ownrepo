<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrationParticipationTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('registration_participation', function(Blueprint $table) {
			$table->unsignedInteger('user_id');
			$table->string('token')->unique();
			$table->boolean('selected')->default(0);
			$table->timestamp('selected_at')->nullable();
			$table->timestamps();

			$table->primary(['user_id', 'token']);

			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('registration_participation');
	}
}
