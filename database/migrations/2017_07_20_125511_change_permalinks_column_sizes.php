<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePermalinksColumnSizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->string('permalink', 511)->change();
        });
        Schema::table('albums', function (Blueprint $table) {
            $table->string('permalink', 511)->change();
        });
        Schema::table('bands', function (Blueprint $table) {
            $table->string('permalink', 511)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
