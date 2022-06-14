## Laravel9.0_ReserveDocker

このコードは以下 Udemy セミナーを参考に Docker 上に作成したものです。<br>
■ [【Laravel】【Jetstream x Livewire】TALL スタックでイベント予約システムをつくってみよう](https://www.udemy.com/course/laravel-livewire-event-calendar/)<br>

## 事前準備

Windows と Mac で環境が異なります。それぞれ以下を参照にしてください。<br>

### 1. docker 等のインストール<br>

・Mac<br>
■ Mac に Docker Desktop インストール<br>
https://docs.docker.jp/docker-for-mac/install.html#install-and-run-docker-desktop-on-mac

・ Windows<br>
■ Windows10 における Laravel Sail の最適な開発環境の作り方（WSL2 on Docker）
https://zenn.dev/goro/articles/018e05bee92aa1

2. エイリアスの設定<br>
   [エイリアスの設定](https://qiita.com/print_r_keeeng/items/544d14e4e0eab0508985#%E3%82%A8%E3%82%A4%E3%83%AA%E3%82%A2%E3%82%B9%E8%A8%AD%E5%AE%9A)

## DownLoad 方法

### 1. コマンド

(1) 対象フォルダーへ移動

```
cd folder
```

(2) github よりコードをダウンロード

```
git clone https://github.com/ABenn17282002/Laravel9.0_Reserve

// git cloneブランチを指定してダウンロードする場合
git clone -b ブランチ名 https://github.com/ABenn17282002/Laravel9.0_Reserve
```

### 2. 直接 DownLoad する方法

(1) 下記の URL を開きます。
https://github.com/ABenn17282002/Laravel9.0_Reserve
(2) 画面左上の「main」部分より branch を選択します
(3) 画面右上にある「Code」ボタンをクリックします
(4) ポップアップしたウィンドウの Download ZIP をクリックすると zip ファイルとしてダウンロードできます。
(5) PC 側で zip ファイルを展開します

## Install 方法

(1) 下記コマンドで sail docker のダウンロード<br>

```
// プロジェクトフォルダーへ移動
> cd projectfoleder

> curl -s "https://laravel.build/example-app" | bash

latest: Pulling from laravelsail/php81-composer
eff15d958d66: Pull complete
  ：
Application ready! Build something amazing.
Sail scaffolding installed successfully.
```

(2) 事前に git hub branch から download したファイルを解凍し、その中身をコピー<br>
sail docker でインストールしたフォルダーにペースト

(3) .env の設定
.env.example をコピーをし.env に変更し以下の部分を変更してください。<br>

```
# DB設定
DB_CONNECTION=mysql
DB_HOST=127.0.0.1 → mysqlに変更
DB_PORT=3306
DB_DATABASE=shoppingcart
DB_USERNAME=root  → 任意のUser名に変更
DB_PASSWORD=      → 任意PW設定
```

(4) 以下コマンドで docker の起動
※ 起動には Internet 環境により異なりますが、20 分程かかります。

```
// dockerの起動
./vendor/bin/sail up -d
```

(5) 以下コマンドで Composer のキャッシュを削除し、
Composer を再インストール

```
// Server環境にlogin
> source ~/.bash_profile
> sail shell
// Composer Cashの削除
sail@*******:/var/www/html$ composer clearcache
// Composerの再インストール
sail@*******:/var/www/html$ composer install
```

(6) ./vendor/bin/sail down で docker を停止し、
./vendor/bin/sail up -d で docker 再起動

(7) php artisan migrate:fresh --seed で
MySQL 上に table とデータを作成。

(8) localhost:8578 でブラウザ確認
カレンダー画面が閲覧出来れば OK。

※ 検証中 Install 方法
■ [Laravel Sail で作成したプロジェクトを GitHub リポジトリに push して利用する](https://qiita.com/kai_kou/items/bfea0281689b3d376812)

## インストール後の実施事項

### 1. プロフィール画像の設定

プロフィール画像作成には以下手順にて storage フォルダーにリンクを貼ってください
(1) Server 環境に Login

```
/laravel_project/Reserve_app$  source ~/.bash_profile
~/laravel_project/Reserve_app$ sail shell
sail@*******:/var/www/html$
```

(2) storage フォルダーにリンクを貼る

```
sail@*******:/var/www/html$php artisan storage:link
// 下記messageが出ればOK！
The [/var/www/html/public/storage] link has been connected to [/var/www/html/storage/app/public].
The links have been created.
```

### 2. tailwinds について

Tailwindcss 3.x を使用しており、JustInTime 機能により、使った HTML 内クラスのみ反映されるようになっています。<br>
HTML 編集の際は、npm run watch を実行しながら編集を行うようにしてください。
