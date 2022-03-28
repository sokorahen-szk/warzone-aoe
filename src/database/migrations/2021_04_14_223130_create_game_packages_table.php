<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_packages', function (Blueprint $table) {
            $table->id()->comment('ゲーム種別ID');
            $table->string('name')->comment('ゲーム種別名');
            $table->string('description')->nullable()->comment('ゲーム種別説明');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_packages');
    }
}
