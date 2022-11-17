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