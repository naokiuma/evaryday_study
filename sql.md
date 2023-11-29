## SQLで見れるプロファイル　と　N+1問題について
テキトーにselectし、profileを見ると、下記のような情報が見れる。

opening tables 
preparing 準備
executeing 実行

とか。<br>
navicatならば検索後に結果の横の「profile」。<br>
sqlで見るなら、

```sql
set profiling = 1;
クエリ
show profile;
```



例題：ループで一つ一つ詰め込むとN+1問題が発生するので、一つのクエリにまとめてしまってはいいのでは？でもどっちの方がいいのか迷う。。。ようなとき。<br>
一つのクエリでも、例えば別テーブルから紐づくshop_idの数を取るとかしている場合→<br>
例えば、shopテーブルとshop_memberテーブルがあり、shopをfrom、ひもづくshop_memberの数を取りたい！とき。

```sql
-- これをセレクトに追加
$this->db->select('(SELECT COUNT(*) FROM shop_member WHERE shop_member.shop_id = shop.shop_id AND shop_member.is_active = 1) AS member_count');

--　または、一旦データとった後、ループで一つ一つ下記を走らせる。
-- ループ処理開始
$this->db->from('shop_member');
$this->db->where('shop_member.is_active', 1);
$this->db->where('shop_review.shop_id', $shop_id);
$list[$key]['shop_member_count'] = $this->db->count_all_results();
-- ループ処理終了

```

どっちがいいのか？というときに、「後者の方がn+1が起こるからダメ」と画一的に考えないこと。<br>
前者でも、結局shop_member.shop_id = shop.shop_idのところで、n+1に近いことをしている。<br>
前述のプロファイルで、executeingで実行しているが、そのまえの準備で時間がかかっているなら、結局のところn+1をクエリの中でやっているに過ぎない。<br>
excutingの時間、準備にかかる時間などを見て、prepareingが増えているならn+1の対策でまとめても効果がないケースもある。さまざまな条件からケースバイケースで考えること


## join時に条件指定するのと、join後にwhereで条件指定するのはどちらが早い？
基本的には結果も実行計画も同じ。

## 稼働中のサービスにindexを貼る際に注意すること
indexを貼っている間、1レコードずつを処理しているので、件数が多ければその間そのテーブルに待ちが発生してしまう。
またそのテーブルが普段から使われているものであれば、その処理もindexを貼っている間待ち時間が発生する。
既存コードの修正などの影響度と合わせて、既存テーブルにindexをはるか、新しいテーブルを作るかなどの選択肢を検討すること。

# mamp 
## mamp環境にターミナルでアクセスするには
参考：　https://www.i-ryo.com/entry/2020/08/02/191316

```
cd /Applications/MAMP/Library/bin/

//でmamp配下に入る

./mysql -u root -p

//でmysql起動。

show DATABASES

//で確認
```

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

## shopとshop_jobなど、二つのテーブル両方に存在しているお店があり。イレギュラーで、片方には存在していない場合に、それを洗い出すクエリ
NOT EXISTSを使う<br>
https://poko-everyday.com/sql%E3%81%A7%E7%89%87%E6%96%B9%E3%81%AE%E3%83%86%E3%83%BC%E3%83%96%E3%83%AB%E3%81%AB%E3%81%97%E3%81%8B%E5%AD%98%E5%9C%A8%E3%81%97%E3%81%AA%E3%81%84%E3%83%87%E3%83%BC%E3%82%BF%E3%81%AE%E6%8A%BD/



## DB移行など、異なるdbのtbl_aとtbl_bのテーブルが全く同じか、比較するときに行えるsql（tbl_aとtbl_bの行数がまず同じであることを確認。例として両方3行の場合）
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


## メモ
結合時に条件をwhereで指定する場合とwhereの変更
※roopでクルクル回しているので、inner joinでどんどん数が減ってしまう。
https://zukucode.com/2017/08/sql-join-where.html

where_inで早くできないか？
