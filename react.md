## 再レンダリングするタイミング
stateの値が変わるたび、コンポーネントが上から実行される。
propsが更新されたコンポーネントも再レンダリングされる
再レンダリングされたコンポーネント配下の子要素も。

routerにはhashやブラウザルーターやらがある。
これにより機能が微妙に違うが、今はブラウザルーターで良さそう。
switchは文字通りswitch文的に、マッチした時点で抜ける。
exactは基本指定した方が良さそう。

---react!3より
コードについてはこちらを参考。
https://github.dev/oukayuka/Riakuto-StartingReact-ja3.1

## ブラウザ履歴系の機能を使いたい場合はusehistory

HTML5 の Hisotry API が提供する生の History オブジェクトでなく、
React Router が独自に定義している同じ名前の history オブジェクト
主な要素
・length...... スタックされている履歴の数
・action...... 直近に実行されたアクションの種類("PUSH","REPLACE","POP")
・push(PATH) ...... 引数 PATH で指定したパスに移動するメソッド
・replace(PATH) ...... 引数 PATH で指定したパスにリダイレクトするメソッド(現在いるページの 履歴は消える)
・goBack()...... ひとつ前の履歴のページに戻るメソッド ・goForward()...... ひとつ先の履歴のページに進むメソッド 
・go(N) ...... 引数 N で指定した番号の履歴に移動するメソッド


## routeのコンポーネント属性について
routeのコンポーネント属性で呼ばれたコンポーネントのpropsには、
history、location、matchオブジェクトが格納されている。→だが、6系ではhistoryは廃止。

## uselocationとは
locationオブジェクトで渡される情報を捕まえる関数。
locationオブジェクトは。。。
https://exampleapp.com/user/patty?from=user-list#friends
の場合、こんなの。(p-31)

{
pathname: '/user/patty', search: '?from=user-list', hash: '#friends',
state: {
[secretKey]: '9qWV408Zyr', },
key: '1j3qup', }
uselocationで渡す依存配列にはこのkeyを使うと良い


## useParamsとuseRouteMatchとは
react routerが提供するmatchオブジェクトをハンドリングするためのapi

useParams・・・urlパラメータだけを抽出する。
useRouteMatch...matchオブジェクトを丸ごと取得。
useRouteMatchからデータを取ろうとするとかなり冗長なので、useParamsを使うと楽なケースが多い。

matchオブジェクトは、、、こんなの。
{
path: "/user/:userId", 
url: "/user/patty", 
isExact: true, 
params: {
userId: "patty", }
}


## react helmetについて
どこからでもhtmlドキュメントヘッダを同的に上書きしてくれる。


##５系と6系の違い

1.Switchが廃止され、Routesが導入。
<Switch> はマッチした <Route> があり次第、それ以降の評価をせず処理を抜ける。が、<Routes> では最後まで評価した上で、ベストマッチする <Route> にルーティングされる
並び順によってマッチするものが変わってしまうので、注意が必要

2.nest routeがかけるようになった。(りあくと！3-p47あたりがわかりやすい)
  outletはnested routeの中のプレースホルダー。ネストされたマッチされたコンポーネントが出力される
  
3.exactおよびstrict属性が廃止。
  正規表現も使えず、末尾の*のみがマッチする。
  
## apiサーバーにpostする際、なぜか301がかえる
  拡張機能のrest_client試した際に301がかえる→
  https://teratail.com/questions/57999
  が原因。
  
