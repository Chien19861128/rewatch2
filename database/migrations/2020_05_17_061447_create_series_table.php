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
            $table->string('title2')->nullable();
            $table->string('title3')->nullable();
            $table->smallInteger('year');
            $table->string('season', 6);
            $table->decimal('year_season', 8, 4);
            $table->string('type', 10);
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
