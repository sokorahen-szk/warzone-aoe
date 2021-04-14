<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maps', function (Blueprint $table) {
            $table->id()->comment('マップID');
            $table->unsignedBigInteger('game_package_id')->comment('ゲーム種別ID');
            $table->string('name', 50)->comment('マップ名');
            $table->string('image')->comment('マップ画像');
            $table->string('description')->nullable()->comment('マップ説明');

            $table->foreign('game_package_id')->references('id')->on('game_packages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maps');
    }
}
