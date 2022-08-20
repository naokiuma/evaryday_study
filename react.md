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
history、location、matchオブジェクトが格納されている。

## uselocationとは
locationオブジェクトで渡される情報を捕まえる関数。
locationオブジェクトは。。。こんなの。
{
pathname: '/user/patty', search: '?from=user-list', hash: '#friends',
state: {
[secretKey]: '9qWV408Zyr', },
key: '1j3qup', }


uselocationで渡す依存配列にはこれを使うと良い

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



