<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\User;
use App\Models\Product;

class ChatMessageSeeder extends Seeder
{
    public function run()
    {
        $buyer  = User::where('email', 'test@example.com')->first();
        $seller = User::where('email', 'seller@example.com')->first();
        $product = Product::where('name', '革靴')->first();

        if (!$buyer || !$seller || !$product) {
            return;
        }

        Message::create([
            'product_id' => $product->id,
            'user_id'    => $buyer->id,
            'body'       => 'この商品はまだ購入可能でしょうか？',
            'is_read'    => false,
        ]);

        Message::create([
            'product_id' => $product->id,
            'user_id'    => $seller->id,
            'body'       => 'はい、まだ購入可能です。よろしくお願いします！',
            'is_read'    => false,
        ]);
    }
}