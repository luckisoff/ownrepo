<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('customs', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('category_id');
      $table->string('name', 255)->nullable();
      $table->string('title', 255);
      $table->string('slug')->unique();
      $table->string('image', 1000)->nullable();
      $table->longText('description');
      $table->boolean('active');
      $table->boolean('home')->default(0);
      $table->timestamps();

      $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('customs');
  }
}
