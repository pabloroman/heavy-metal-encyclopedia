<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeleteColumnsToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('albums', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('bands', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->softDeletes();
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
            $table->dropColumn('deleted_at');
        });

        Schema::table('bands', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}
