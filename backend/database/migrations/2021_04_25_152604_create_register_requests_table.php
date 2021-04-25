<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisterRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_requests', function (Blueprint $table) {
            $table->id()->comment('新規登録リクエストID');
            $table->unsignedBigInteger('player_id')->unique()->comment('プレイヤーID');
            $table->unsignedBigInteger('user_id')->nullable()->comment('ユーザID');
            $table->tinyInteger('status')->default(0)->comment('新規登録リクエストステータス');
            $table->text('remarks')->nullable()->comment('備考');

            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('register_requests');
    }
}
