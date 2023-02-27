# ProducTrack

ProducTrack は、エンジニアの生産性を可視化するためのウェブアプリケーションです。

## 機能

-   GitHub との連携

    GitHub API を利用して、リポジトリ、issue、commit、Pull request などの情報を取得します。
    また、GitHub の OAuth を使用してログイン機能を実装しているため、ユーザーは GitHub アカウントで簡単にログインできます。

-   生産性指標の算出

    取得した情報をもとに、issue の平均クローズ時間、プルリクエストのマージ数、コミット数などの指標を算出します。
    これらの指標は、エンジニアの生産性を評価するためのスコア算出に利用されます。
    スコアの算出は、

    `issueの平均クローズ時間 / ((issueのクローズ数 + comiit数) * プルリクエストのマージ数)`

    という式に基づいて計算されます。

-   生産性の可視化

    算出された生産性指標をもとに、エンジニアのスコアを算出し、グラフで推移を可視化します。
    スコアの推移には、日単位、週単位、月単位などのグラフ表示が可能です。

以上が、当アプリの機能の概要です。本アプリは、エンジニアの生産性を可視化することで、自己評価やチームメンバーとの比較などに役立つことが期待されます。

## 技術スタック

-   バックエンド: PHP 8.0.2
-   フレームワーク: Laravel 9.19
-   コンテナ: Docker
-   データベース: MySQL (バージョン X.X)
-   クラウドプラットフォーム: AWS <-デプロイしなかったら消す
-   依存関係管理: Composer
-   認証機能: Laravel Breeze 1.19
-   ソーシャルログイン: Laravel Socialite 5.6
-   フロントエンド: Tailwind CSS, jQuery, Chart.js, Preline

## 環境構築手順

1. リポジトリをクローン

    ```sh
    git clone https://github.com/Phase4TeamI/TeamI
    ```

2. 必要なディレクトリの作成

    ```sh
    mkdir -p storage/framework/cache/data/
    mkdir -p storage/framework/app/cache
    mkdir -p storage/framework/sessions
    mkdir -p storage/framework/views
    ```

3. コンテナ動作に必要なファイルをダウンロード & インストール

    ```sh
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php81-composer:latest \
        composer install --ignore-platform-reqs
    ```

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

1. ログイン  
    `Continue with Github` からGitHubでログインします。  
    
2. リポジトリの登録  
    `Register Repository` からリポジトリを登録します。  
    リポジトリ名・リポジトリのURLをそれぞれ入力します。  

3. Webhokの設定  
    登録したリポジトリをGitHubで開きます。  
    `ettings -> Webhooks -> Add webhook` からWebhookの設定を行います  
    `Payload URL` に `アプリケーションURL/payload` を設定します。  
    `Content type` を `application/json` へ変更します。  

## 今後の展望

-   同じリポジトリに所属する他のユーザーのスコアを見ることができる管理者ユーザーの追加
-   生産性を測るための指標の追加 (例：コードの質、修正したバグの数、リファクタリングの行数など)
-   ユーザーが独自に指標を追加・選択できるようにする機能の追加
-   スコア算出方法の改善

    クローズ数やコミット数、プルリクエストのマージ数は、単に数値の合計を使うだけでは、それぞれの重要性を反映できない。例えば、コミット数が多ければ生産性が高いとは限らず、修正すべき問題が多く発生している可能性があるため、コミットの品質やコミット数とリンクした指標を考える必要がある。また、issue の平均クローズ時間は、プロジェクトの規模や種類によって大きく異なる。
    全ての指標が同等に重要だとは限らず、それぞれの重要度を評価して、重み付けすることも必要である。

## 作成者

-   星加 大樹

    福岡デザイン&テクノロジー専門学校 2 年

-   安藤 太希

    福岡工業大学 3 年

-   黒川 怜雄

    九州大学工学部電気情報工学科 3 年

## 謝辞

    このアプリの制作にあたり、メンターとしてご指導いただいた株式会社マネーフォワードの杉本至様に、心より感謝申し上げます。杉本様からいただいたアドバイスやフィードバックによって、私たちはエンジニアとして成長することができました。ありがとうございました。

## ライセンス

"ProducTrack" is under [MIT license](https://en.wikipedia.org/wiki/MIT_License).
