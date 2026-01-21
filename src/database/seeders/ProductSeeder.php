<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            // =====================
            // 出品した商品（あかさん）
            // =====================
            [
                'name' => '腕時計',
                'price' => 15000,
                'brand_name' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'image_path' => 'products/armani.jpg',
                'condition' => '良好',
                'user_id' => 1,
                'buyer_id' => null,
                'is_sold' => false,
            ],
            [
                'name' => 'HDD',
                'price' => 5000,
                'brand_name' => '西芝',
                'description' => '高級感を醸し出す黒いハードディスク',
                'image_path' => 'products/hdd.jpg',
                'condition' => '目立った傷や汚れなし',
                'user_id' => 1,
                'buyer_id' => null,
                'is_sold' => false,
            ],
            [
                'name' => '玉ねぎ3玉束',
                'price' => 300,
                'brand_name' => null,
                'description' => '新鮮な玉ねぎ3つセット',
                'image_path' => 'products/onion.jpg',
                'condition' => 'やや傷や汚れあり',
                'user_id' => 1,
                'buyer_id' => null,
                'is_sold' => false,
            ],

            // =====================
            // 購入した商品（取引完了）
            // =====================
            [
                'name' => '革靴',
                'price' => 4500,
                'brand_name' => null,
                'description' => 'クラシックなデザインの革靴',
                'image_path' => 'products/shoes.jpg',
                'condition' => '状態が悪い',
                'user_id' => 2,     // 出品者
                'buyer_id' => 1,   // あかさんが購入
                'is_sold' => true,
            ],
            [
                'name' => 'ノートPC',
                'price' => 45000,
                'brand_name' => null,
                'description' => '最新のノートパソコン',
                'image_path' => 'products/laptop.jpg',
                'condition' => '良好',
                'user_id' => 2,
                'buyer_id' => 1,
                'is_sold' => true,
            ],

            // =====================
            // 取引中の商品（未完了）
            // =====================
            [
                'name' => 'マイク',
                'price' => 8000,
                'brand_name' => null,
                'description' => '高品質のレコーディング用マイク',
                'image_path' => 'products/mic.jpg',
                'condition' => '目立った傷や汚れなし',
                'user_id' => 2,
                'buyer_id' => 1,
                'is_sold' => false,
            ],
            [
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'brand_name' => null,
                'description' => 'おしゃれなショルダーバッグ',
                'image_path' => 'products/bag.jpg',
                'condition' => 'やや傷や汚れあり',
                'user_id' => 2,
                'buyer_id' => 1,
                'is_sold' => false,
            ],
            [
                'name' => 'タンブラー',
                'price' => 500,
                'brand_name' => null,
                'description' => '使いやすいタンブラー',
                'image_path' => 'products/tumbler.jpg',
                'condition' => '状態が悪い',
                'user_id' => 2,
                'buyer_id' => 1,
                'is_sold' => false,
            ],
            [
                'name' => 'コーヒーミル',
                'price' => 4000,
                'brand_name' => 'Starbucks',
                'description' => '手動のコーヒーミル',
                'image_path' => 'products/coffee.jpg',
                'condition' => '良好',
                'user_id' => 2,
                'buyer_id' => 1,
                'is_sold' => false,
            ],
            [
                'name' => 'メイクセット',
                'price' => 2500,
                'brand_name' => null,
                'description' => '便利なメイクアップセット',
                'image_path' => 'products/makeup.jpg',
                'condition' => '目立った傷や汚れなし',
                'user_id' => 2,
                'buyer_id' => 1,
                'is_sold' => false,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}