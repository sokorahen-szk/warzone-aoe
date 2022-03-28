<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rules', function (Blueprint $table) {
            $table->id()->comment('ルールID');
            $table->unsignedBigInteger('game_package_id')->comment('ゲーム種別ID');
            $table->string('name', 50)->comment('ルール名');
            $table->string('description')->nullable()->comment('ルール説明');

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
        Schema::dropIfExists('rules');
    }
}
