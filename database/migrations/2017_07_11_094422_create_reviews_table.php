<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('permalink')->nullable();
            $table->date('published_at')->nullable();
            $table->integer('score')->nullable();
            $table->text('title')->nullable();
            $table->text('body')->nullable();
            $table->string('author')->nullable();
            $table->integer('author_id')->unsigned();
            $table->integer('album_id')->unsigned();

            $table->unique(['author_id', 'album_id']);
            $table->foreign('album_id')->references('id')->on('albums');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
