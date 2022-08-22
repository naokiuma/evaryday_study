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
