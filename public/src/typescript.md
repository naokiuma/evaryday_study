## ジェネリクスがからの配列かどうかをチェックするには
```
T extends [] ? 
```

## タプル（型情報をセットしている配列みたいなもの）など、Mapped Types が使えない場合はどう型にアクセスする？
Indexed Access Types を利用して T[number] という型制約を利用。タプルに対して T[number] とアクセスすると配列から型を取得できる。

```
const array = ['apple', 'banana', 'strawberry'] as const
type Arr = typeof array // ['apple', 'banana', 'strawberry']
type Fruits = Arr[number] // "apple" | "banana" | "strawberry"
```



## テストの話
カスタムフックをテストしたい場合<br>
具体的には、カスタムフック内のクエリをテストしたい場合。
https://zenn.dev/bom_shibuya/articles/5c3ae7745c5e94#

## メモ系の話
useCallback・・・コールバック関数をメモ化する。
react.memo・・・子コンポーネントをメモ化する。useCallbackで関数をメモ化し、その関数を子供に渡せば効果を発揮する。<br><br>
例えば、react.memoだけしていると、親が再レンダーされた時に関数も再生成されるので、react.memoで包んだ子供も再レンダされる。<br>
useMemo・・・変数自体をメモ化する。


## コンポーネントへの引数の渡し方
こうすることで、オブジェクトそのものを渡すことができる。
```
<GameCard key={each_game.id} {...each_game} />

//こうではないので注意
// <GameCard key={each_game.id} props={...each_game}/>

```

## ts基本の諸々参考url!忘れたらここを見よう
https://zenn.dev/ogakuzuko/articles/react-typescript-for-beginner

## apiなどへのリクエストをし、その返り値に型定義をすることについて
tsはどんな値が返ってくるかがわからないので、自身で記載する必要がある。<br>
apiによってはかなり階層が深いので、全てを記載することは難しい。が、記載しておけば受け取ってからの調整などもしやすくなる。<br>
また、利用したいデータ以外の指定は不要。（tsはその他の値もわからないのでエラーにはならないはず）

## declareキーワードにより、変数を宣言すると
tsに対して、この変数は存在しているからチェックは不要だと伝えることができる。<br>
htmlファイルに書かれていたり、jsファイルの中にだけあるサードパーティライブラリや、人間にはあると分かってるけど、<br>tsはそれがわからないのでエラーになるグローバル変数などを使いたい場合
```
declare var GLOBAL:string
```
などをtsの中で書いておく。tsに存在するよと伝えておくことで、エラーを出さないようにできる。<br>
ただ、これだとtsの恩恵を受けられないので、typesファイルがあればそれをインストールしよう（例えばgoogle mapの表示をtsで使う場合、typsのgoogleを検索して利用しよう）（udemyのgoogleマップ講座参考）<br>

関数や変数を中身なしに宣言することもできる。
```
declare function foo(arg: number): number;
```

## サードパーティライブラリのts宣言ファイル
https://github.com/DefinitelyTyped/DefinitelyTyped
<br>
大量のjsファイルがtsになったものが配置されている。ライブラリを使いたい場合はここに存在するかをみよう。<br>
xxx.d.ts など、declaition（宣言）されたファイルをインストールしておけば使える。devのみのインストールでもok

## デコレータについて

デコレータとは何か？まず。tsconfgiをts6にして、experimentalDecoratorsをtrueに。<br>
一般的にデコレータはclassにつけるもの<br>
デコレータはただの関数。その関数を、特定の方法でクラスに適用するということ。<br><br>

◼️基本情報<br>
デコレータは、2つ以上を設定することができる。<br>
なお、デコレーター内の関数の実行順序は、下から順に実行される。<br>
ロガーファクトリー自体は普通に上から順に実行される。<br><br>

◼️デコレーターを追加できる場所<br>
デコレーターを利用するには、classが必要<br>
classの中で設定で消える箇所が複数ある。<br>
クラスの定義上。<br>
コンストラクタ関数の上。<br>
アクセサの上。<br>
メソッドの上。<br><br>

◼️実行タイミング<br>
クラスをインスタン化した時に作られるわけではない。<br>
クラスが「定義された時に実行される。」<br><br>

◼️クラスデコレーターやメソッドデコレータは、値を返すことができる。<br>
かなりややこしいので、113をよく見ること！<br><br>

◼️メソッドデコレーターはPropertyDescriptorの設定を値として返すことができる<br>
PropertyDescriptor　とは？オブジェクトのプロパティのメタ属性でデータアクセスに関する取り決めを保持しています。<br>
https://qiita.com/hosomichi/items/db5c501272b622fdd848#%E3%83%87%E3%82%A3%E3%82%B9%E3%82%AF%E3%83%AA%E3%83%97%E3%82%BF%E3%81%AE%E3%83%A1%E3%82%BF%E5%B1%9E%E6%80%A7<br>
あたりを参考。<br><br>
デコレータでバリデートもできる。116~118<br><br>

こちらにコードのより詳細<br>
https://github.com/naokiuma/understanding_ts/blob/master/src/decorator.ts

## ジェネリクスについて
こちらに詳細<br>
https://github.com/naokiuma/understanding_ts/blob/master/src/generics.ts

## 交差型や型ガードについて
こちらに詳細。<br>
https://github.com/naokiuma/understanding_ts/blob/master/src/advanced_type.ts

## typeやinterfaceを使う理由
例えば、greetableというinterfaceがある。
これには、greet()というメソッドを型として持たせる。
interfaceは、複数のクラスに設定できる。
例えば、複数のクラスにて「greet()という関数を持たせる」ことを担保できる。

さらに、interfaseは別のinterfaceを継承することもできる。
※typeでもできるけど、ちょっとややこしい。<br>
typeとinterfaceの違い<br>
https://qiita.com/tkrkt/items/d01b96363e58a7df830e

また、この継承時、1つのinterfaceに複数のinterfaceを継承することもできる。


## tsでのtypeofは、変数から型を抽出する。
jsでのtsとは少し違うので、注意。
具体的には？
```
const point = { x: 135, y: 35 };
type Point = typeof point;

//上記の、Pointには、これが入る。
type Point = {
    x: number;
    y: number;
}
```

## javascriptにはinterfaceは存在しない
interfaceは出力されない。開発中のもの。

## typescriptはクラス定義すると、二つの宣言が同時に実行される。
クラスインスタンスのインターフェース、とコンストラクタ関数


## 関数の型定義について
```
type IsPositiveFunc = (arg: number) => boolean;

//関数の型はこのように(引数名: 型) => 返り値の型という形で書くことができます。型システム上、型にかかれている引数名（arg）に意味はありません。

また、interfaceの場合、

interface IsPositiveFunc {
  (arg: number): boolean;
}

ともかける
```

## ジェネリクスについて

[React]Generic型のコンポーネントを作る

code:tsx
 type Props<T> = {
   data: T
 }
 
 // 定義元
 const Smaple = <T extends {}>(props: Props<T>) => {}
 
 // 呼び出し側
 const APP = () => {
   return (
     <Sample<string> data="文字">
     <Sample<number> data="数値">
   )
 }
 
`<T extends {}>`
arrowでコンポーネントを定義する場合必要。
TypeScriptの型であると判別させるために必要。オブジェクトならなんでもOKとしている。


```
# 変数
const numbers:number[]=[1,2,3]
という書き方もできるし、
const numbers:Array<string> = ['one','two',three']
という書き方もできる。
```


## keyofは
そのオブジェクトのkeyを全て取得する

## neverはどんなときに使う？
絶対に変数をセットしない。→ switchの最後で誤って数字を入れたりしないように。（リアクト!のts序盤より）

## as constとは
オブジェクトや配列をconstで定義するとき、その中身もread onlyにする方法。<br>
https://typescriptbook.jp/reference/values-types-variables/const-assertion

## 関数の型宣言

```
const toArray = <T>(num1:T,num2:T):T[] => [num1,num2];
toArray(8,3) //[8,3]
toArray('foo','bar') //['foo','bar']
toArray(5,'bar') //エラー！

//Tは型引数。これを引数で使ってね、という指定。num1,num2にTを指定しているので、三つ目はエラーになる
//こんなふうに、データの型に束縛されないように抽象化して、コードの再利用性を向上させつつ、
型安全を維持する手法を、ジェネリックプログラミングと呼ぶ

//ちなみに、こんなふうに引数の数を可変長にできる。
const toArray2 = <T>(...args:T[]):T[] => [...args];
toArray2(1,2,3,4,5)

※jsの場合はこんな感じ
https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Functions/rest_parameters

```

## Partialについて
次の型Partial<T>はTのプロパティを全てオプショナルにした型です。この型は便利なのでTypeScriptの標準ライブラリに定義されており、自分で定義しなくても使うことができます。全てのプロパティをreadonlyにするReadonly<T>もあります。

```
type Partial<T> = {[P in keyof T]?: T[P]};
```



## VFCの横の大文字のPropsとは何を表している？
具体的には、こういうコード
```
const TEST :VFC"<Props>" = (props) => ...後略
```

propsのtypeによる型定義。こんな感じで使える。
https://github.dev/oukayuka/Riakuto-StartingReact-ja3.1
  
08-componentのCharacterList.tsx参考

パターン１
```
type Props = {
  school: string;
  characters: Character[];
};

const CharacterList: VFC<Props> = (props) => {
  const { school, characters } = props;
```
 
パターン２
 ```
export const TopicForm:FC<{isActive:boolean}> = memo((props) => {
  
//または
//複数のpropsがある場合はこういう書き方をし、PropsをFCの横に入れる。
// type Props ={
//     isActive:boolean
// }
  
```
<br>こんな感じで子コンポーネント定義。<br>
親はこういうふうに渡せる<br>
  ```
<TopicForm isActive={true} />
```
