<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameRecordTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_record_tokens', function (Blueprint $table) {
            /**
             * 試合記録トークンは常にユニークになる。このトークンを使って勝敗を付けれるようになっている。
             * 未ログイン者ユーザ向け。ログイン済みユーザはマイページから勝敗つけれるため、このトークンは使っても
             * 使わなくてもどちらでもよい。
             *
             * YYYYMMDDhhmmss<ランダム文字数 length:36>
             *
             */
            $table->string('game_token', 50)->unique()->comment('試合記録トークン');

            $table->unsignedBigInteger('game_record_id')->comment('試合記録ID');

            // トークンの有効期限
            // トークン発行日時 + 6時間
            $table->dateTime('expires_at')->comment('有効期限');

            $table->primary('game_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_record_tokens');
    }
}
