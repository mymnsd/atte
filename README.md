# Atte

「Atte」は勤怠管理ができるアプリです。

会員登録をすると毎日の勤怠を記録でき、日付別の勤怠記録の閲覧もできます。

## 作成目的
laravel学習のまとめとして作成しました。

与えられた要件やイメージをもとにテーブル作成、ER図、コーディングを行いました。

## 機能一覧
　・会員登録（名前、メールアドレス、パスワード、確認用パスワードを入力）
 
　・ログイン（メールアドレスとパスワードで認証）、ログアウト
 
　・勤怠の打刻
 
 　　 →出勤、退勤打刻
 
　　 →休憩開始、終了打刻
 
　・ユーザーの日付別勤怠記録の表示

 ## 使用技術
  ・PHP7.4.9
  
  ・laravel8
  
  ・MySQL8.0.26

## 環境構築

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


