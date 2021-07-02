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
            $table->unsignedBigInteger('rule_id')->comment('ルールID');
            $table->unsignedBigInteger('map_id')->comment('マップID');

            $table->integer('winning_team')->nullable()->comment('勝利チーム');
            $table->integer('victory_prediction')->nullable()->comment('勝利予測');

            //
            // status
            // 1 = matching, 2 = draw, 3 = canceled, 4 = finished
            $table->tinyInteger('status')->default(0)->comment('試合ステータス');
            $table->dateTime('started_at')->comment('試合開始時間');
            $table->dateTime('finished_at')->nullable()->comment('試合終了時間');

            $table->foreign('game_package_id')->references('id')->on('game_packages');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('rule_id')->references('id')->on('rules');
            $table->foreign('map_id')->references('id')->on('maps');
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
