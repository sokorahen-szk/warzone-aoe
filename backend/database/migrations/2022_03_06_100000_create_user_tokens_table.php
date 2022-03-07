<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_tokens', function (Blueprint $table) {
            $table->id()->comment('パスワード再発行ID');
            $table->unsignedBigInteger('user_id')->comment('ユーザID');
            $table->string('email')->comment('メールアドレス');
            $table->string('token')->unique()->comment('トークン');
            $table->dateTime('expires_at')->nullable()->comment('トークンの有効期限');
            $table->timestamps();

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
        Schema::dropIfExists('user_tokens');
    }
}