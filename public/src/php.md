## 関数と計算量メモ
```
$order_shop_ids = array_reverse($shop_ids);
$temp_shop_data_order_by = array_combine($order_shop_ids, $order_shop_ids);
foreach ($shop_data as $_shop_data) {
	$temp_shop_data_order_by[$_shop_data['shop_id']] = $_shop_data;
}
$shop_data = array_values($temp_shop_data_order_by);
```
これと、
```
$order_shop_ids = array_reverse($shop_ids);
$new_list = [];
foreach ($shop_data as $_shop_data) {
	foreach ($order_shop_ids as $_shop_id) {
		if ($_shop_data['shop_id'] === $_shop_id) {
			$new_list[] = $_shop_data;
			break;
		}
	}
}
$shop_data = $new_list;
```
これを比べた際に後者は2重のforになっているが、かなり早い。<br>
（※件数が4件の場合。件数が増えてきた場合はこの限りではない。）<br>
前者で使っているarray_combineやarray_baluesは計算量がO(n)ということもあり、速度としては前者の方が遅かった。<br>

計算量についてはこちらもかなりわかりやすいのでおすすめ<br>
https://speakerdeck.com/hanhan1978/basic-knowledge-of-time-complexity?slide=22




## PHP Docsの書き方
arrayのパラメータを渡したい場合、下記のstored_。。。ファンクションを参考に。<br>
https://github.com/ionixeternal/Codeigniter-3/blob/main/system/database/drivers/oci8/oci8_driver.php

## 判定について
もし $hoge 変数には0か１が入りうる場合、それに0か1が入っているかを判定するときに

```
if($hoge){}
```
で判定すると、今後2とか3が変数に入るよう拡張するときにわかりづらい。<br>
また、返ってくる値が０や1なのであれば、最初から $hoge == 1 や $hoge == 0で判定する癖をつけよう。

## 関数色々
sprintf の中でsprintfをするより、ゼロ埋めしよう。<br>
https://gray-code.com/php/fill-numbers-with-zeros/

```
//※011桁で埋める
sprintf("/items/%s/",sprintf("%011d", $item_id)
//ではなく、
sprintf("/items/%011d/",$item_id)
```

array_column・・・配列の、第二引数で指定した値のみ返す。selectみたいなイメージ。<br>
array_unique・・・重複した値を削除する。
```php
array_unique(array_column($data['areas'], 'area_id')
```

例えば下記のようなデータなら、

```php
	[0] => Array
        (
            [area_mid_id] => 13
            [area_mid_name] => 東京
        )
        [1] => Array
        (
            [area_mid_id] => 13
            [area_mid_name] => 東京
		)
	[2] => Array
        (
            [area_mid_id] => 13
            [area_mid_name] => 東京
		)
	[3] => Array
        (
            [area_mid_id] => 14
            [area_mid_name] => 埼玉
		)
  
```
まずはarray_colmunで
```php
[0] => 13
[1] => 13
[2] => 13
[3] => 14・・・
```

となり、さらにarray_uniqueで、
```php
[0] => 13
[3] => 14
```
となる。



## テストで、落ちているサーバーへの通信を試したい時

https://httpstat.us/
<br/>
こちらのサイトがおすすめ。

## クラス色々
abstractをつけてるとnewできない<br>

## マジックメソッドとプライベートメソッドの違い

__test()・・・と二つ付けたらマジックメソッド。

_test()・・・と一つつけたらプライベートメソッド。

## 関数の返り値をbooleanにしていると、string返してるつもりなのにbooleanで返ってしまう

例として下記のような関数を作っている。

```php

function say_hoge():bool
{
  return 'hoge';
}

```

この関数をよんでいる場所で、この関数の結果を見ると、なぜか「1」で返っている。

原因としては、関数の返り値の定義をの「bool」に指定しているから。
関数内のコードが少し複雑なこともあり（上の見本はシンプルですが）
どっかで真偽値に変わってるのか？としばらく調査してしまっていました。。。
ちなみに、定義をarrayにすると Fatal error: Uncaught TypeError
