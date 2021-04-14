<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id()->comment('プレイヤーID');
            $table->string('name', 30)->comment('プレイヤー名');
            $table->float('mu')->comment('μ値');
            $table->float('sigma')->comment('σ値');
            $table->integer('rate')->comment('レート');
            $table->integer('min_rate')->comment('最小レート');
            $table->integer('max_rate')->comment('最大レート');
            $table->integer('win')->comment('勝利数');
            $table->integer('defeat')->comment('敗北数');
            $table->integer('games')->comment('試合数');
            $table->dateTime('joined_at')->comment('参加日');
            $table->dateTime('last_game_at')->comment('最終ゲーム日');
            $table->boolean('enabled');
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
        Schema::dropIfExists('players');
    }
}
