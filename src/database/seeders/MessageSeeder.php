<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class MessageSeeder extends Seeder
{
    public function run()
    {
        $seller1 = User::where('email', 'seller1@example.com')->first();
        $buyer = User::where('email', 'freeuser@example.com')->first();

        if (!$seller1 || !$buyer) {
            echo "ユーザーが見つかりません。\n";
            return;
        }

        $products = Product::where(function ($q) use ($seller1, $buyer) {
                $q->where('user_id', $seller1->id)
                  ->orWhere('buyer_id', $buyer->id);
            })
            ->where('is_completed', false)
            ->get();

        foreach ($products as $index => $product) {
            Message::create([
                'product_id' => $product->id,
                'user_id' => $buyer->id,
                'body' => "未読メッセージ（$product->name）",
                'is_read' => false,
                'created_at' => Carbon::now()->subMinutes($index),
                'updated_at' => Carbon::now()->subMinutes($index),
            ]);
        }

        echo "商品ごとに新着順の未読メッセージを作成しました。\n";
    }
}