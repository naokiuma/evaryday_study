##  99%のケースで、取得したデータは「そのまま state にぶち込む」のが正解です。
<br>
react.dev には次のように書いてあります<br>
既存の props または state から何かを計算できる場合は、それを state に入れないでください。<br>
この説明以上に明快な説明は、おそらく他のどこにもないと思います。<br>
React の黄金のルールの一つです。<br>
https://zenn.dev/t_keshi/books/you-and-cleaner-react/viewer/inherited-proliferated-state


## contextについて
プロバイダーで指定したvalueを1コンポーネントで二つ以上設定している場合、どっちか一つが更新されるだけで、この二つを使ってるコンポーネント全てが再レンダリングされる。<br>
ので、それを抑えたい場合はプロバイダー自体を二つとかに分けるテクがある。

## ifの基本
https://chaika.hatenablog.com/entry/2019/05/16/083000

## reactでfetchして、値が入るまでloadingする方法（よく使うのでサンプル。）

```

useEffect(() => {
    getGame(game_id).then((data)=>{
      set_game(data);
      setIsLoading(false);
        })
    },[])
    
<div>
    {isLoading ? (
        <p>Loading...</p>
    ) : (
        <>
            <span>
                {data[0].name}
            </span>
        </>
    )}
</div>

```



## react-routerのリダイレクト手順。
v6以降はuseNavigateを使用。
```
import { useNavigate } from 'react-router-dom';

function LoginPage() {
  const navigate = useNavigate(); 
  //ここでnavigateに置き換える必要がある。
  //useNavigate()はReactコンポーネント内でのみ使用することがでため、
  //関数コンポーネント内で直接useNavigate()を使用することはできません。

  if (isLoggedIn) {
    navigate('/dashboard');
    
```

## テストの参考
https://www.webopixel.net/javascript/1777.html<br>
yarn run test

## jsxの中で&&で繋いでtrueなら返し、falseなら完全に無視する三項演算子的っぽい書き方
https://qiita.com/horiy0125/items/fa07f5baa6028b9746ce

## propsで渡す方法
波線で渡す。波線の中はいろんな形がいける。文字列だけ渡す場合はそのまま渡せる。

## reactからjsでlaravelにpostする方法
```
//こんな感じでformDataに付与する。
const formData = new FormData()
formData.append("file", imgData)
```
と、
```
//こんなふうにheadersにmultipartが必要
 axios
  .post(
    target_URL,
    {title: title,body: body,status: status,file:formData},
    {
     headers: {
     'Content-Type': 'multipart/form-data',//画像を送る際にはこの指定が必要},withCredentials:true,
    },
         
```

## 再レンダリングするタイミング
stateの値が変わるたび、コンポーネントが上から実行される。</br>
propsが更新されたコンポーネントも再レンダリングされる</br>
再レンダリングされたコンポーネント配下の子要素も。</br>

## ルーターの話。
routerにはhashやブラウザルーターやらがある。
これにより機能が微妙に違うが、今はブラウザルーターで良さそう。
switchは文字通りswitch文的に、マッチした時点で抜ける。
exactは基本指定した方が良さそう。

---react!3より
コードについてはこちらを参考。
https://github.dev/oukayuka/Riakuto-StartingReact-ja3.1

## react-routerでurl直うちすると白紙になる問題
head内に<base href="/">を記述し、サーバーを「再起動」すればすおk

## ブラウザ履歴系の機能を使いたい場合はusehistory

HTML5 の Hisotry API が提供する生の History オブジェクトでなく、React Router が独自に定義している同じ名前の history オブジェクト<br>
主な要素<br>
・length...... スタックされている履歴の数<br>
・action...... 直近に実行されたアクションの種類("PUSH","REPLACE","POP")<br>
・push(PATH) ...... 引数 PATH で指定したパスに移動するメソッド<br>
・replace(PATH) ...... 引数 PATH で指定したパスにリダイレクトするメソッド(現在いるページの 履歴は消える)<br>
・goBack()...... ひとつ前の履歴のページに戻るメソッド ・goForward()...... ひとつ先の履歴のページに進むメソッド <br>
・go(N) ...... 引数 N で指定した番号の履歴に移動するメソッド<br>


## routeのコンポーネント属性について
routeのコンポーネント属性で呼ばれたコンポーネントのpropsには、<br>
history、location、matchオブジェクトが格納されている。→だが、6系ではhistoryは廃止。

## useEffectとは
そのコンポーネントが再レンダリングされるたびに呼ばされる。<br>
常に監視しているとメモリリークなど起きることもあるので、不要になったら購読解除する。<br>
useeffect中でreturnすると、クリーンアップ関数を使って、そのuseeffectを使わないようにできる<br>
参考：https://qiita.com/seira/items/e62890f11e91f6b9653f


## React.memo　コンポーネントをメモ化する。<br>
以下、メモ系はこの記事を参考にした。https://qiita.com/soarflat/items/b9d3d17b8ab1f5dbfed2#usememo

```
//propsが更新されるまで、このコンポーネントは再更新されない。
const Hello = React.memo(props => {
  return <h1>Hello {props.name}</h1>;
});
```

## useCallbak react.memoを使ったコンポーネントに渡す「関数」に使う
アロー関数でかいた関数は、reactの中で新しい関数として認識される。<br>
なので、propsで子供にアロー関数を渡した場合、渡す先の子供をReact。memo化していても、毎回描写されてしまう。<br>
それを抑えるために、関数自体をusecallbackで包む。（第二引数は監視対象。これが変わると再描写される。）<br>

React.memoでメモ化をしていないコンポーネントにuseCallbackでメモ化をしたコールバック関数を渡す<br>
useCallbackでメモ化したコールバック関数を、それを生成したコンポーネント自身で利用する<br>

```
import React, { useState, useCallback } from "react";

const Child = React.memo(props => {
  console.log("render Child");
  return <button onClick={props.handleClick}>Child</button>;
});

export default function App() {
  console.log("render App");

  const [count, setCount] = useState(0);
  // 関数をメモ化すれば、新しい handleClick と前回の handleClick は
  // 等価になる。そのため、Child コンポーネントは再レンダリングされない。
  const handleClick = useCallback(() => {
    console.log("click");
  }, []);

  return (
    <>
      <p>Counter: {count}</p>
      <button onClick={() => setCount(count + 1)}>Increment count</button>
      <Child handleClick={handleClick} />
    </>
  );
}
```

## useMemo　メモ化された値を返すフック。
値に対して使う、と考えると良さそう。
useMemo(() => 値を計算するロジック, 依存配列);

## 計算結果をキャッシュする場合は、useeffectではなくusememoを使おう。
https://zenn.dev/t_keshi/books/you-and-cleaner-react/viewer/inherited-scattered-effect<br>
また、useEffect に渡した関数は、レンダリング後に実行されます。<br>
レンダリングライフサイクルから脱出する必要がないときに useEffect は不要です。


## uselocationとは
locationオブジェクトで渡される情報を捕まえる関数。<br>
locationオブジェクトは。。。<br>
https://exampleapp.com/user/patty?from=user-list#friends<br>
の場合、こんなの。(p-31)<br>
```
{
pathname: '/user/patty', search: '?from=user-list', hash: '#friends',
state: {
[secretKey]: '9qWV408Zyr', },
key: '1j3qup', }
```
uselocationで渡す依存配列にはこのkeyを使うと良い<br>


## useParamsとuseRouteMatchとは
react routerが提供するmatchオブジェクトをハンドリングするためのapi<br><br>

useParams・・・urlパラメータだけを抽出する。<br>
useRouteMatch...matchオブジェクトを丸ごと取得。<br>
useRouteMatchからデータを取ろうとするとかなり冗長なので、useParamsを使うと楽なケースが多い。<br>
<br>
matchオブジェクトは、、、こんなの。<br>
```
{
path: "/user/:userId", 
url: "/user/patty", 
isExact: true, 
params: {
userId: "patty", }
}
```

## react helmetについて
どこからでもhtmlドキュメントヘッダを同的に上書きしてくれる。


##５系と6系の違い

1.Switchが廃止され、Routesが導入。<br>
<Switch> はマッチした <Route> があり次第、それ以降の評価をせず処理を抜ける。が、<Routes> では最後まで評価した上で、ベストマッチする <Route> にルーティングされる<br>
並び順によってマッチするものが変わってしまうので、注意が必要<br>

2.nest routeがかけるようになった。(りあくと！3-p47あたりがわかりやすい)<br>
  outletはnested routeの中のプレースホルダー。ネストされたマッチされたコンポーネントが出力される<br>
  
3.exactおよびstrict属性が廃止。<br>
  正規表現も使えず、末尾の*のみがマッチする。<br>
  
## apiサーバーにpostする際、なぜか301がかえる
  拡張機能のrest_client試した際に301がかえる→<br>
  https://teratail.com/questions/57999<br>
  が原因。URLの末尾に/が付いていたため。<br>
 
## Contextではデータを渡す側をProviderと呼びデータを受け取る側をConsumerと呼びます。
この辺が参考になった。<br>
https://nishinatoshiharu.com/react-context-cases/
  <br>
  保持した情報をキャッシュなど？で持つには<br>
  https://nobunobu1717.site/?p=2443<br>
  で次回やってみる<br>
  
