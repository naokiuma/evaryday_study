# sql
## ウィンドウ関数

とは・・・？
行をまとめず、集合関数のようにまとめた結果を別途表示する。

[基礎]
over句

## partition by
`select id, item, count(*) over (partition by item) from items;`

結果

id | item | count(*) over (partition by item) 
1|  apple|   3
2|  apple|   3
3|  orange|  1
4|  apple|   3

## window 指定
row 行数
range orderbyで指定したカラムの値への指定。
を指定する。
ordery by も必須。


## マジックナンバーはなるべくテーブルには使わない
例えば
クーポン利用前金額A、飲み放題時間B
クーポン利用後金額C、飲み放題時間D
の4つがある場合、num1、num2、num3、num4ではなく、
before_money、befote_time、
after_money、after_timeなど。

## 「Delete → Insert」　または「まとめてUpdate」

参考
https://oreno-it.info/archives/2855

それぞれの利点

・コードの見易さ、作りやすさ
前者はコードがシンプルになりやすい。
後者は既存データと突き合わせた上で違ったらアップデートする、という面倒気味なコードになりやすい）

・パフォーマンスの観点
前者は変更が2回走るが、後者は1回

・イレギュラーケース
前者はデリートした時点でサーバーがもし落ちたら・・・？というケースのことを考えてみる。
例えば選択肢を選ばせるような編集画面なら、落ちても大した問題ではない。逆に契約関連など、お金に絡むような重要な箇所の場合は慎重に考える必要が高まる。


## mySQLの中で関数を作ったり、ループをする方法
ストアドプロシージャ
https://qiita.com/chihiro/items/5d438549b5869900abdd
ストアドプロシージャでループ
https://oreno-it3.info/archives/499

カーソルを使ってやる方法 !役にやつ！
https://www.wakuwakubank.com/posts/789-mysql-cursor/
https://style.potepan.com/articles/24824.html

