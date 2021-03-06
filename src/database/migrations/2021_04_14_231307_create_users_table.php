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
            $table->unsignedBigInteger('player_id')->unique()->comment('プレイヤーID');
            $table->unsignedBigInteger('role_id')->comment('ロールID');
            $table->string('name', 16)->unique()->comment('ユーザ名');
            $table->string('steam_id', 30)->nullable()->comment('SteamID');
            $table->string('twitter_id', 50)->nullable()->comment('TwitterID');
            $table->string('website_url')->nullable()->comment('WebサイトURL');
            $table->string('avator_image')->nullable()->comment('ユーザ画像');
            $table->string('email')->nullable()->default('sample@example.com')->comment('メールアドレス');
            //
            // status
            // 1 = waiting, 2 = active, 3 = withdrawal, 4 = banned
            $table->tinyInteger('status')->default(2)->comment('ユーザステータス');
            $table->string('password')->comment('パスワード');
            $table->rememberToken();
            $table->timestamps();

            // $table->foreign('player_id')->references('id')->on('players');
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
