<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->comment('ユーザID');
            $table->unsignedBigInteger('player_id')->comment('プレイヤーID');
            $table->unsignedBigInteger('role_id')->comment('ロールID');
            $table->string('name')->comment('ユーザ名');
            $table->string('steam_id', 30)->comment('SteamID');
            $table->string('twitter_id', 50)->comment('TwitterID');
            $table->string('website_url')->comment('WebサイトURL');
            $table->string('avator_image')->comment('ユーザ画像');
            $table->string('email')->unique()->comment('メールアドレス');
            $table->string('password')->comment('パスワード');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('player_id')->references('id')->on('players');
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
