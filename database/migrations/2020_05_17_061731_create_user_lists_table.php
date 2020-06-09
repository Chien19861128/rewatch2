<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_lists', function (Blueprint $table) {
            $table->string('mal_user_id', 50);
            $table->string('mal_series_id', 10);
            $table->tinyInteger('status');
            $table->float('weighted_score', 4, 4);
            $table->tinyInteger('episode');
            $table->primary(['mal_user_id', 'mal_series_id']);
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
        Schema::dropIfExists('user_lists');
    }
}
