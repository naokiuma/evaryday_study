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


## 全ての組み合わせを、重複を除外してとる

りんご
みかん
バナナ

を、他の物との組み合わせと合わせる

select p1.name AS name_1,p2.name AS name_2
FROM items p1 inner join items p2
on p1.name <> p2.name;

りんご　みかん
りんご　バナナ
みかん　りんご
みかん　バナナ
バナナ　りんご
バナナ　みかん


## DB移行など、異なるdbのtbl_aとtbl_bのテーブルが同じか、比較するときに行えるsql（tbl_aとtbl_bの行数がまず同じであることを確認。例として両方3行の場合）
select count(*) as row_cnt
from(select * from tbl_A 
     union
    select * from tbl_b) tmp
    
→結果が3となれば完全一致
・・・unionは　allオプションをつけなければ、重複行を削除するため。
なお、例えば1行違いがあれば4が帰ってくる。


## 繰り返し項目を1列にまとめる

社員|child_1|child_2|child_3
----------------------------
赤井 一郎     二郎    三郎
工藤 春子     夏子
鈴木 夏子
吉田

こんな感じで繰り返しになっているテーブルを、こんな感じにするには。。

テーブル：personnel
社員 child
-----------
赤井 一郎
赤井 二郎
赤井 三郎
工藤 春子
工藤 夏子
工藤 
鈴木 夏子
鈴木
鈴木
吉田
吉田
吉田

select 社員,child_1 as child
union all
select 社員,child_2 as child
union all
select 社員,child_3 as child

union allでそれぞれの全パターンを抽出。
childがnullのものを排除したい場合はwhereでそうする
