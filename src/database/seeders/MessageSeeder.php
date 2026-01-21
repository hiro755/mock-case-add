<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\Product;
use App\Models\User;

class MessageSeeder extends Seeder
{
    public function run()
    {
        $user1 = User::find(1);
        $user2 = User::find(2);

        if (!$user1 || !$user2) {
            echo "ユーザーが見つかりません。\n";
            return;
        }

        $products = Product::where(function ($q) use ($user1) {
                $q->where('user_id', $user1->id)
                ->orWhere('buyer_id', $user1->id);
            })
            ->where('is_completed', false)
            ->get();

        foreach ($products as $product) {
            Message::create([
                'product_id' => $product->id,
                'user_id' => $user2->id,
                'body' => 'これはSeederで作成された未読メッセージです',
                'is_read' => false,
            ]);
        }

        echo "未読メッセージを作成しました（Seeder）\n";
    }
}