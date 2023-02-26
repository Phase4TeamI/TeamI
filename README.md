# ProducTrack

ProducTrack は、エンジニアの生産性を可視化するためのウェブアプリです。

## 機能

## 環境

-   php 8.0.2
-   laravel 9.19
-   laravel Breeze 1.19
-   Laravel Socialite 5.6

## インストール方法

1. リポジトリをクローン

    ```sh
    git clone https://github.com/Phase4TeamI/TeamI
    ```

2. 必要なディレクトリの作成

    このまま起動すると必要なディレクト入りがなくてエラーになる．

    そのため，下記コマンドを順に実行して必要なディレクトリを作成する．

    ```sh
    mkdir -p storage/framework/cache/data/
    mkdir -p storage/framework/app/cache
    mkdir -p storage/framework/sessions
    mkdir -p storage/framework/views
    ```

3. コンテナ動作に必要なファイルをダウンロード & インストール

    Laravel Sail の実行に必要な vendor ディレクトリは Git では管理されていない．そのため，コマンドを実行して用意する必要がある．

    下記コマンドを実行すると自動的に全部入る．6 行まとめて入力して実行すること．

    ```sh
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php81-composer:latest \
        composer install --ignore-platform-reqs
    ```

    【参考】 https://readouble.com/laravel/9.x/ja/sail.html

4. .env.example をコピーして .env ファイルを作成

    ```sh
    cp .env.example .env
    ```

    ファイルができたら mysql 設定部分を以下のように編集する．

    ```bash:.env
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=teami
    DB_USERNAME=sail
    DB_PASSWORD=password
    ```

5. コンテナを起動

    ```sh
    ./vendor/bin/sail up -d
    ```

6. アプリケーションキーを生成

    ```sh
    ./vendor/bin/sail php artisan key:generate
    ```

7. GitHub 認証の設定

    - https://github.com/settings/developers にアクセス
    - 「New OAuth App」をクリックして
      以下のように入力

        - Application name（任意）

        - Homepage URL

            `http://localhost/`

        - Application description（任意）

        - Authorization callback URL
          `http://localhost/login/github/callback`

    - 「Register Application」をクリック

    アプリが登録されて、Client ID と Client Secret が発行されるので.env に追記する。

    ```bash:.env
    GITHUB_CLIENT_ID=xxx
    GITHUB_CLIENT_SECRET=xxx
    GITHUB_URL=http://localhost/login/github/callback
    GITHUB_TOKEN=
    ```

8. マイグレーション

    ```sh
    ./vendor/bin/sail php artisan migrate
    ```

    ブラウザから`localhost`にアクセスするとアプリケーションの動作が確認できます。
    `localhost:8080`にアクセスすると phpmyadmin にアクセスできます。

    コンテナを終了させるときは

    ```sh
    ./vendor/bin/sail down
    ```

## 使い方

## 作成者

-   星加 大樹
-   安藤 太希
-   黒川 怜雄

## ライセンス

"ProducTrack" is under [MIT license](https://en.wikipedia.org/wiki/MIT_License).
