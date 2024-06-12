## docker compose exec -ti とは？
docker compose exec -ti コマンドは、Docker Compose を使用して実行中のコンテナ内でコマンドを実行するためのものです。<br>
これは docker exec -it コマンドに似ていますが、Docker Compose のサービス名を使用して特定のコンテナにアクセスします。<br><br>

基本構文
```sh
docker compose exec -ti <サービス名> <コマンド>
```
<サービス名>: docker-compose.yml ファイル内で定義されているサービス名。<br>
<コマンド>: 実行したいコマンド。例えば、sh や bash などのシェルコマンド。<br><br>

オプション<br>
-t: 擬似端末を割り当てる。<br>
-i: 標準入力を保持する。<br><br>

例<br>
1. bash シェルを起動する<br>
特定のサービスコンテナ内で bash シェルを起動します。例えば、サービス名が web であれば以下のように実行します。
```sh
docker compose exec -ti web bash
```

2. sh シェルを起動する<br>
軽量なシェルである sh を使用してコンテナ内に入る場合は以下のように実行します。
```sh
docker compose exec -ti web sh
```

3. 特定のコマンドを実行する<br>
コンテナ内で特定のコマンドを実行する場合は、以下のように実行します。<br>
```
docker compose exec -ti db psql -U postgres
```
ここで、db はデータベースサービスの名前で、psql -U postgres はコンテナ内で実行する PostgreSQL クライアントコマンドです。<br>



## 大量の画像をコピーしたい！
以下で、今いるフォルダのあるa.pngを1.png、2.png...と大量に作ることができる
```
for i in {1..100}; do cp a.png $i.png; done
```

## sshコマンドの補足
```
ssh aa@example.com -i hoge.pem -p 11111
```
aaはユーザー名で、example.comはホスト名。この部分は、接続先のリモートサーバー。<br>
-i hoge.pemは、pemファイルの置き場所を指定。<br>
-p 11111 は、ポート番号の指定



## ■ログ調査時の便利なコマンド

grep系 （参考：https://eng-entrance.com/linux-command-grep#-v)

マッチしないものを検索する。たとえば下記なら、1を含まない行を検索する
```
grep -v 1 ファイル名
```

パイプラインで繋ぐと強力。<br>
以下は、アクセスログファイルから404を絞り、さらに/shop/というurlを含まないものを表示する。<br>
（リファラーurlとかもあるので、使い方はよく考えること。GET /shopとか、文字列で絞り込むと良い。）<br>

```
grep " 404 " access.log | grep -v "/shop/"
```

tailfはリアルタイムに最後の10行を表示してくれる。例えば下記は、GET /shop/を含む404のログを、リアルタイムに表示する。
```
tailf ssl_access.log | grep " 404 " | grep "GET /shop/"
```

・find系・・・変更したファイルなどを絞り込みたい場合など。再起的に処理をするので、行う場所は注意！！<br>
-mtime:指定した日に変更を行ったファイルやディレクトリを検索。今日が0、昨日が1。
この場合つまり機能変更したファイルを絞り込む。
```
find -mtime 1
```

## grep、zgrepについて
grep "500" access.log とか、zgrep "404" ファイル名とか。その文字列が存在しない場合はノーリアクションなので注意！<br>
通常ファイルを試す場合　grep ‘探す文字列’ファイル名<br>
Zipファイルを試す場合　zgrep  ‘探す文字列’ファイル名<br>

## ■アクセスログを見るために行った作業

sshでrootユーザーで接続→web上でも見ることは可能だが、手元で見たい場合・・・

1.ファイルをコピーする
cp コピー元 コピー先

2.ファイルの所有者を変える(ftp接続だとダウンロード)
chown ec2-user /home/www/xxxxx.jp/access.log

3.それをFTPなどでダウンロードする

他・todo<br>
https://qiita.com/katsukii/items/225cd3de6d3d06a9abcb <br>
これでダウンロードすることも可能ではある。。。が、やろうとするとフィンガープリントを求められたので一旦中断。<br>
また、web上でlessコマンドで見ることも可能。tailならばリアルタイムで反映も可能。

一例<br>
less -N  行番号を表示する<br>
less -N  折り返しをしない。<br>
less -NS 上記両方のオプション。<br>

## ■エラーログの見方<br>
左から、接続元IP、日付、GETやPOST、接続元、ステータスコードとバイト数、リファラー。ない場合は「-」、ユーザー、一番右に、接続元IPに踏み台しているIP<br>
<br>

## ■アクセスログに記載されているヘルスチェックとは？<br>
サーバー側で死活確認に行っているアクセス。<br>

