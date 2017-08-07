<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReviewCountColumnToBandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bands', function (Blueprint $table) {
            $table->integer('review_count')->unsigned()->nullable();
        });

        App\Models\Band::chunk(100, function ($bands) {
            foreach($bands as $band) {
                $band->review_count = $band->albums->sum('review_count');
                $band->save();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bands', function (Blueprint $table) {
            $table->dropColumn('review_count');
        });
    }
}
