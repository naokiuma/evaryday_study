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
