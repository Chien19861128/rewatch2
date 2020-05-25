<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSumListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sum_lists', function (Blueprint $table) {
            $table->string('mal_series_id', 10)->primary();
            $table->integer('total_watching');
            $table->integer('total_ptw');
            $table->integer('weighted_watching_score');
            $table->integer('weighted_ptw_score');
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
        Schema::dropIfExists('sum_lists');
    }
}
