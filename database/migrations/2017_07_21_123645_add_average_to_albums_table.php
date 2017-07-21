<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAverageToAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('albums', function (Blueprint $table) {
            $table->float('average_score', 6, 3)->nullable();
            $table->float('median_score', 6, 3)->nullable();
            $table->integer('review_count')->unsigned()->nullable();
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
            $table->dropColumn('average_score');
            $table->dropColumn('median_score');
            $table->dropColumn('review_count');
        });
    }
}
