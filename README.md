模擬案件
環境構築
Docker ビルド
 1.git clone git@github.com:Estra-Coachtech/laravel-docker-template.git
 2.docker-compose up -d --build

 ※MySQL は、OS によって起動しない場合があるのでそれぞれの PC に合わせて docker-compose.yml ファイルを編集してください。

Laravel 環境構築
 1.docker-compose exec php bash
 2.composer install
 3.cp .env.example .env
 4..env ファイルの一部を以下のように編集
    DB_HOST=mysql
    DB_DATABASE=laravel_db
    DB_USERNAME=laravel_user
    DB_PASSWORD=laravel_pass

 5.php artisan key:generate
 6.php artisan migrate
 7.php artisan db:seed
 8.php artisan storage:link
 9.cp -r sample_images/* storage/app/public/

user のログイン用初期データ
 ・メールアドレス：hiro2536@icloud.com
 ・パスワード：newpassword1234
　　*商品購入画面→決済時に、決済確認及び完了の画面を追加で作成　laravel/mock-case/src/resources/views/paymentsに記述

使用技術
　・MySQL 8.0.26
　・PHP 7.4.9-fpm
　・Laravel 8

URL
　・開発環境： http://localhost/login
　・phpMyAdmin: http://localhost:8080/

ER図
<img width="1920" height="1080" alt="スクリーンショット 2025-10-27 172547" src="https://github.com/user-attachments/assets/881b79e7-8946-4716-87ff-733a8f7549af" />

Pro入会テスト　機能要件の追加
1.mypage.blade.phpに取引中の商品タグ及び評価（★）の追加
2.cd mock-case/src/resources/viewsにmkdir chatで作成後、show.blade.php（チャット画面）を実装
3.show.blade.php（チャット画面）で評価用のモーダル実装
4.cd mock-case/src/public/css/chat.cssを追加

ユーザーのダミーデータ
・出品者１→email:eller1@example.com
          passward:Pass1234!

・出品者２→email:eller2@example.com
          passward:Pass1234!

・未出品者→email:freeuser@example.com
          passward:Pass4567!



　
