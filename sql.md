# sql
## ウィンドウ関数

とは・・・？
行をまとめず、集合関数のようにまとめた結果を別途表示する。

[基礎]
over句

## partition by
`select id, item, count(*) over (partition by item) from items;`

結果

id | item | count(*) over (partition by item) <br>
1|  apple|   3<br>
2|  apple|   3<br>
3|  orange|  1<br>
4|  apple|   3<br>

## window 指定
row 行数
range orderbyで指定したカラムの値への指定。
を指定する。
ordery by も必須。


## マジックナンバーはなるべくテーブルには使わない
例えば<br>
クーポン利用前金額A、飲み放題時間B<br>
クーポン利用後金額C、飲み放題時間D<br>
の4つがある場合、num1、num2、num3、num4ではなく、<br>
before_money、befote_time、<br>
after_money、after_timeなど。<br>

## 「Delete → Insert」　または「まとめてUpdate」

参考<br>
https://oreno-it.info/archives/2855

それぞれの利点<br>

・コードの見易さ、作りやすさ<br>
前者はコードがシンプルになりやすい。<br>
後者は既存データと突き合わせた上で違ったらアップデートする、という面倒気味なコードになりやすい）

・パフォーマンスの観点<br>
前者は変更が2回走るが、後者は1回<br>

・イレギュラーケース<br>
前者はデリートした時点でサーバーがもし落ちたら・・・？というケースのことを考えてみる。<br>
例えば選択肢を選ばせるような編集画面なら、落ちても大した問題ではない。逆に契約関連など、お金に絡むような重要な箇所の場合は慎重に考える必要が高まる。


## mySQLの中で関数を作ったり、ループをする方法
ストアドプロシージャ<br>
https://qiita.com/chihiro/items/5d438549b5869900abdd<br>
ストアドプロシージャでループ<br>
https://oreno-it3.info/archives/499<br>
<br>
カーソルを使ってやる方法 !役にやつ！<br>
https://www.wakuwakubank.com/posts/789-mysql-cursor/<br>
https://style.potepan.com/articles/24824.html<br>

注意！<br>
ストアドプロシージャをphpmyadminなどで実行する場合は、デリミタで設定した終端文字を戻さないといけない。<br>
例として<br>

```
-- ストアドプロシージャの定義
DELIMITER //
CREATE PROCEDURE Test()
BEGIN
	-- 特になにもしない
END
//

-- ストアドプロシージャの実行
CALL Test();

SELECT * FROM items;
```

などをまとめて1回のsqlで実行すると、SELECT * FROM items; でエラーになる。
// の後ろに
DELIMITER ;

を挿入すると、終端文字は;に戻るので、正常に実行される。


## 全ての組み合わせを、重複を除外してとる

りんご<br>
みかん<br>
バナナ<br>
<br>
を、他の物との組み合わせと合わせる<br>

select p1.name AS name_1,p2.name AS name_2<br>
FROM items p1 inner join items p2<br>
on p1.name <> p2.name;<br>

りんご　みかん<br>
りんご　バナナ<br>
みかん　りんご<br>
みかん　バナナ<br>
バナナ　りんご<br>
バナナ　みかん<br>


## DB移行など、異なるdbのtbl_aとtbl_bのテーブルが同じか、比較するときに行えるsql（tbl_aとtbl_bの行数がまず同じであることを確認。例として両方3行の場合）
select count(*) as row_cnt<br>
from(select * from tbl_A <br>
     union<br>
    select * from tbl_b) tmp<br>
    
→結果が3となれば完全一致<br>
・・・unionは　allオプションをつけなければ、重複行を削除するため。<br>
なお、例えば1行違いがあれば4が帰ってくる。<br>


## 繰り返し項目を1列にまとめる

社員|child_1|child_2|child_3<br>
----------------------------<br>
赤井 一郎     二郎    三郎<br>
工藤 春子     夏子<br>
鈴木 夏子<br>
吉田<br>

こんな感じで繰り返しになっているテーブルを、こんな感じにするには。。

テーブル：personnel<br>
社員 child<br>
-----------<br>
赤井 一郎<br>
赤井 二郎<br>
赤井 三郎<br>
工藤 春子<br>
工藤 夏子<br>
工藤 <br>
鈴木 夏子<br>
鈴木<br>
鈴木<br>
吉田<br>
吉田<br>
吉田<br>
```
select 社員,child_1 as child
union all
select 社員,child_2 as child
union all
select 社員,child_3 as child
```
union allでそれぞれの全パターンを抽出。<br>
childがnullのものを排除したい場合はwhereで指定する<br>


## countの中で条件を書くことができる

## codeignitor でjoin先をサブクエリ
https://www.kabanoki.net/2015/


##　繰り返しフィールドを繰り返し解除した後の結合
fromをshopにするなら、<br>
shopクーポン_1_の中でtype1<br>
クーポン_2_の中でtype2	<br>
という感じでそれぞれ結合するといい感じになる。<br>
			
fromをクーポンにするなら<br>
coupon	この中で情報は揃ってるはずなので、これを元にすると良さそう	

## グループごとに上位いくつかを取得
https://qiita.com/ryota_i/items/8d0cc238c269fe9ca016<br>
ちなみにrow_number使わずにやる方法。これ参考になる<br>
https://gihyo.jp/dev/serial/01/sql_academy2/000102<br>

## codeignitorでのメモ
fromにサブクエリをかくと、joinする時にエラーとなる（自動で括弧を増やしてしまう様子）。
自己結合でright joinをしてしまえば良い


## 集約してから結合するのと、結合してから集約ではどちらが早い？ from わかりみ339

 「集約して結合」と「結合して集約」はどっちが効率的?<br>
ここでは「集約してから結合」と「結合してから集約」の 2 つのアプロー チを説明しました。効率的に実行されるのはどちらでしょうか?<br>
たいていの場合は、前者の「集約してから結合」のほうが実行が効率的 です。なぜなら、行数の多いテーブルを結合するよりも行数の少ないテー ブルを結合するほうが実行コストがかからないからです*3 。<br>
• 前者の「集約してから結合」の場合、16 行あった成績テーブルを集約 して 4 行にしてから、生徒テーブルと結合します。<br>
• これに対して後者の「結合してから集約」の場合、16 行ある成績テー ブルをそのまま生徒テーブルと結合し、そのあとで成績を集計します。<br>
そのため、前者の「集約してから結合」のほうが結合する行数が少ないの で、後者よりも効率的に実行されるのです。<br>
