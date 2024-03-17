# laravel sailでの環境構築

## アプリ構築
```
curl -s "https://laravel.build/laravel-app" | bash
```
desktopにいる状態で行うと、laravel-appがdesktopに作られる。

## アプリ起動
```
 cd laravel-app && ./vendor/bin/sail up
```
対象のフォルダに移動し、起動。
### ※以降、sailを使ってるの操作が必要。

## このままlocalhostに行くとエラー。
```
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'laravel.sessions' doesn't exist 
```
テーブルの構築がまず必要。
起動している状態のまま、vscodeなどから別のターミナルを使いlaravel-appに移動。その上で
```
/vendor/bin/sail artisan migrate
```
これでテーブルなどが用意される。

## ここまでの参考記事(マイグレーションは記載がないが)
https://qiita.com/Naaaa/items/9b9b6b05a93b8b8f3cec

