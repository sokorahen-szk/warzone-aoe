<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_records', function (Blueprint $table) {
            $table->id()->comment('試合記録ID');
            $table->unsignedBigInteger('game_package_id')->comment('ゲーム種別ID');
            $table->unsignedBigInteger('user_id')->comment('ユーザID');
            $table->integer('winning_team')->nullable()->comment('勝利チーム');
            $table->enum('status', ['matching', 'drew', 'canceled', 'finished']);
            $table->dateTime('started_at')->comment('試合開始時間');
            $table->dateTime('finished_at')->nullable()->comment('試合終了時間');

            $table->foreign('game_package_id')->references('id')->on('game_packages');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_records');
    }
}
