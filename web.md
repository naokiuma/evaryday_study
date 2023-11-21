## 環境変数系
macアップデートしてphpが消えた時の話（基本アップデートすると消える）。下記の2つの記事がわかりやすい<br>
zashcを触った後はsourceを適用する必要があるので注意！<br>
https://www.stub-create.com/blog/php/mamp-brew.html<br>
https://tech.amefure.com/php-homebrew#google_vignette<br>
<br>
この二つの違いは？<br>
https://kanasys.com/tech/803#index1-0

## プリフライトリクエストを起こす条件
ブラウザが自動でoptionsとして送ってくれる。<br>
例としてjsのfetchの場合、カスタマイズヘッダーを追加した場合、自動で送ってくれた。(firefoxの場合)<br>
下記のx-access-tokenのつけ外しでプリフライトリクエストの有無が変わりました。

```
headers: {
  'x-access-token':xxxx-xxxx-xxxx,
  'Content-Type': 'application/json'
}
```

## サーバーキャッシュが強い場合の挙動について

・サーバーキャッシュが強く設定されている場合、クッキーでサイトの動作をコントロールするのは推奨されない

1.phpでクッキーをコントロールする<br>
サーバーはphpにたどり着く前にキャッシュされたhtmlファイルを返すので、phpの$_COOKIEなどでコントロールをしようと思っても、その前に構成されたhtmlファイルを返してしまう。

2.jsでクッキーをコントロールする<br>
サーバーがキャッシュされたhtmlファイルを返す場合でも、htmlファイルの中で読み込んでいるjsでコントロールできるので、サーバーキャッシュが強くても関係ない！


・キャッシュhitしたか否かの判断
レスポンス情報の、x-cache-status: HIT　または miss
