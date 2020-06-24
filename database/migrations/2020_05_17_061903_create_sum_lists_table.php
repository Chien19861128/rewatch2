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
            $table->string('mal_series_id', 50)->primary();
            $table->integer('total_watching')->nullable();
            $table->integer('total_ptw')->nullable();
            $table->decimal('weighted_watching_score', 14, 4)->nullable();
            $table->decimal('weighted_ptw_score', 14, 4)->nullable();
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
