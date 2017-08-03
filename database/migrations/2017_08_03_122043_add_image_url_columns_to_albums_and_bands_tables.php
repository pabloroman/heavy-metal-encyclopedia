<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageUrlColumnsToAlbumsAndBandsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('albums', function (Blueprint $table) {
            $table->renameColumn('image', 'image_url_original');
            $table->string('image_url')->nullable();
        });

        Schema::table('bands', function (Blueprint $table) {
            $table->renameColumn('image', 'image_url_original');
            $table->string('image_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('albums', function (Blueprint $table) {
            $table->renameColumn('image_url_original', 'image');
            $table->dropColumn('image_url');
        });

        Schema::table('bands', function (Blueprint $table) {
            $table->renameColumn('image_url_original', 'image');
            $table->dropColumn('image_url');
        });
    }
}
