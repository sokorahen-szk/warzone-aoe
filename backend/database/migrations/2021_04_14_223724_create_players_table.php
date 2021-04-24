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
            $table->float('mu')->default(0)->comment('μ値');
            $table->float('sigma')->default(0)->comment('σ値');
            $table->integer('rate')->default(0)->comment('レート');
            $table->integer('min_rate')->default(0)->comment('最小レート');
            $table->integer('max_rate')->default(0)->comment('最大レート');
            $table->integer('win')->default(0)->comment('勝利数');
            $table->integer('defeat')->default(0)->comment('敗北数');
            $table->integer('games')->default(0)->comment('試合数');
            $table->string('game_packages')->nullable()->comment('ゲーム種別リスト'); //ゲーム種別IDはカンマ区切りで登録される。複数のPackageに所属する場合があるため。
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
