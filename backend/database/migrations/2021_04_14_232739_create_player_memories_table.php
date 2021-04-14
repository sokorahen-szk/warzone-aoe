<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerMemoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_memories', function (Blueprint $table) {
            $table->id()->comment('個別記録ID');
            $table->unsignedBigInteger('player_id')->comment('プレイヤーID');
            $table->unsignedBigInteger('game_record_id')->comment('試合記録ID');
            $table->integer('team')->nullable()->comment('チーム番号');
            $table->float('mu')->nullable()->comment('μ値');
            $table->float('sigma')->nullable()->comment('σ値');
            $table->integer('rate')->nullable()->comment('レート');

            $table->foreign('player_id')->references('id')->on('players');
            $table->foreign('game_record_id')->references('id')->on('game_records');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_memories');
    }
}
