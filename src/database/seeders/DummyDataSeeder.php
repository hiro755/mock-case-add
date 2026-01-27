<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Message;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run()
    {

        $seller1 = User::firstOrCreate(
            ['email' => 'seller1@example.com'],
            [
                'name' => '出品者1',
                'password' => Hash::make('Pass1234!'),
                'email_verified_at' => now(),
            ]
        );

        $seller2 = User::firstOrCreate(
            ['email' => 'seller2@example.com'],
            [
                'name' => '出品者2',
                'password' => Hash::make('Pass1234!'),
                'email_verified_at' => now(),
            ]
        );

        $buyer = User::firstOrCreate(
            ['email' => 'freeuser@example.com'],
            [
                'name' => '未出品ユーザー',
                'password' => Hash::make('Pass4567!'),
                'email_verified_at' => now(),
            ]
        );


        $products = [
            ['name'=>'腕時計','price'=>15000,'image_path'=>'dummy_images/Armani-Mens-Clock.jpg','condition'=>'良好'],
            ['name'=>'HDD','price'=>8000,'image_path'=>'dummy_images/HDD-Hard-Disk.jpg','condition'=>'目立った傷や汚れなし'],
            ['name'=>'玉ねぎ3束','price'=>300,'image_path'=>'dummy_images/LoveIMG-d.jpg','condition'=>'やや傷や汚れあり'],
            ['name'=>'ノートPC','price'=>45000,'image_path'=>'dummy_images/Living-Room-Laptop.jpg','condition'=>'やや傷や汚れあり'],
            ['name'=>'マイク','price'=>6000,'image_path'=>'dummy_images/Music-Mic.jpg','condition'=>'良好'],

            ['name'=>'ショルダーバッグ','price'=>3500,'image_path'=>'dummy_images/Purse-fashion-pocket.jpg','condition'=>'やや傷や汚れあり'],
            ['name'=>'タンブラー','price'=>1800,'image_path'=>'dummy_images/Tumbler-souvenir.jpg','condition'=>'良好'],
            ['name'=>'コーヒーミル','price'=>4000,'image_path'=>'dummy_images/Waitress-with-Coffee-Grinder.jpg','condition'=>'やや傷や汚れあり'],
            ['name'=>'メイクセット','price'=>2500,'image_path'=>'dummy_images/makeup-set.jpg','condition'=>'目立った傷や汚れなし'],
            ['name'=>'革靴','price'=>9800,'image_path'=>'dummy_images/Leather-Shoes-Product-Photo.jpg','condition'=>'良好'],
        ];

        $createdProducts = [];

        foreach ($products as $index => $data) {
            $createdProducts[] = Product::create([
                'user_id' => $index < 5 ? $seller1->id : $seller2->id,
                'name' => $data['name'],
                'price' => $data['price'],
                'image_path' => $data['image_path'],
                'condition' => $data['condition'],
                'description' => $data['name'] . ' の商品説明ダミーです',
                'is_sold' => false,
                'is_completed' => false,
            ]);
        }

        $createdProducts[0]->update([
            'buyer_id' => $buyer->id,
            'is_sold' => true,
            'is_completed' => false,
        ]);

        $createdProducts[5]->update([
            'buyer_id' => $buyer->id,
            'is_sold' => true,
            'is_completed' => false,
        ]);

        Message::create([
            'product_id' => $createdProducts[0]->id,
            'user_id' => $buyer->id,
            'body' => '購入しました！よろしくお願いします。',
            'is_read' => false,
        ]);

        Message::create([
            'product_id' => $createdProducts[0]->id,
            'user_id' => $seller1->id,
            'body' => 'ありがとうございます！発送準備します。',
            'is_read' => false,
        ]);

        Message::create([
            'product_id' => $createdProducts[5]->id,
            'user_id' => $buyer->id,
            'body' => 'こちらも購入希望です。',
            'is_read' => false,
        ]);
    }
}