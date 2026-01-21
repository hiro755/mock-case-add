<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            // どの商品（取引）に紐づくチャットか
            $table->foreignId('product_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // 送信者
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // メッセージ本文
            $table->text('body');

            // 画像（任意）
            $table->string('image_path')->nullable();

            // 未読管理（FN005対応）
            $table->boolean('is_read')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
