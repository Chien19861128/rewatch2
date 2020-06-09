<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->string('mal_series_id', 50)->primary();
            $table->string('title1');
            $table->string('title2');
            $table->string('title3');
            $table->smallInteger('year');
            $table->tinyInteger('season');
            $table->float('year_season', 4, 4);
            $table->tinyInteger('type');
            $table->smallInteger('episodes');
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
        Schema::dropIfExists('series');
    }
}
