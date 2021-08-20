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
            $table->unsignedBigInteger('user_id')->comment('ユーザID');
            $table->unsignedBigInteger('game_package_id')->comment('ゲーム種別ID');
            $table->string('name', 30)->comment('プレイヤー名');
            $table->float('mu')->default(0)->comment('μ値');
            $table->float('sigma')->default(0)->comment('σ値');
            $table->integer('rate')->default(0)->comment('レート');
            $table->integer('min_rate')->default(0)->comment('最小レート');
            $table->integer('max_rate')->default(0)->comment('最大レート');
            $table->integer('win')->default(0)->comment('勝利数');
            $table->integer('defeat')->default(0)->comment('敗北数');
            $table->integer('games')->default(0)->comment('試合数');
            $table->integer('streak')->default(0)->comment('連勝敗');
            $table->dateTime('last_game_at')->nullable()->comment('最終ゲーム日');
            $table->boolean('enabled')->default(false)->comment('プレイヤー有効設定');
            $table->timestamps();

            $table->unique(['user_id', 'game_package_id']);
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
