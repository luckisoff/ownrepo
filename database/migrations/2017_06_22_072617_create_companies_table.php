<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('companies', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->string('email');
      $table->timestamp('established_date')->nullable();
      $table->string('address')->nullable();
      $table->string('phone')->nullable();
      $table->longText('about')->nullable();
      $table->string('logo')->nullable();
      $table->string('facebook_url', 300)->nullable();
      $table->string('twitter_url', 300)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('companies');
  }
}
