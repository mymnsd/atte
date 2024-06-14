# atte（勤怠管理アプリ）
## 機能一覧
　・会員登録
 
　・ログイン、ログアウト
 
　・勤務開始、終了
 
　・休憩開始、終了
 
　・日付別勤怠情報取得
 
　・ページネーション
 ## 使用技術
  ・PHP7.4.9
  
  ・laravel8
  
  ・MySQL8.0.26

## 環境構築
　１．docker-compose exec php bash

　２．compose install

　３．「.env.example」ファイルを「.env」ファイルに変更。または、新しく.envファイルを作成

　４．.envに以下の環境変数を追加
### Dockerビルド
１．git clone git@github.com:mymnsd/atte.git

２．DockerDesktopアプリを立ち上げる

３．docker-compose up -d --build

### laravel環境構築
１．docker-compose exec php bash

２．composer install

３．「.env.example」ファイルを「.env」ファイルに命名を変更。または、新しく.envファイルを作成

４．.envに以下の環境変数を追加

DB_CONNECTION=mysql

DB_HOST=mysql

DB_PORT=3306

DB_DATABASE=laravel_db

DB_USERNAME=laravel_user

DB_PASSWORD=laravel_pass

５．アプリケーションキーの作成

php artisan key:generate

## テーブル仕様書
![スクリーンショット (29)](https://github.com/mymnsd/atte/assets/158548441/5d5f8307-38ca-4f02-8eb9-60d0faea8625)


## ER図
![スクリーンショット (25)](https://github.com/mymnsd/atte/assets/158548441/074d6c66-cfbb-4651-8533-530b22ec11ec)

## URL
開発環境：http://localhost/

phpMyAdmin:：http://localhost:8080/


