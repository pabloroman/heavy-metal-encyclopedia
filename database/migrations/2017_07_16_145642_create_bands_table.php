<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bands', function (Blueprint $table) {
            $table->integer('id')->unsigned()->primary();
            $table->timestamps();
            $table->string('permalink')->nullable();
            $table->string('name')->nullable();
            $table->string('logo')->nullable();
            $table->string('image')->nullable();
            $table->string('country')->nullable();
            $table->string('status')->nullable();
            $table->string('genre')->nullable();
            $table->string('lyrical_themes')->nullable();
            $table->string('founded_at')->nullable();
        });

        Schema::create('album_band', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('band_id')->unsigned();
            $table->integer('album_id')->unsigned();

            $table->unique(['album_id', 'band_id']);
            $table->foreign('album_id')->references('id')->on('albums');
            $table->foreign('band_id')->references('id')->on('bands');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bands');
        Schema::dropIfExists('albums_bands');
    }
}
