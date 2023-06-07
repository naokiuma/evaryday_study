## ts基本の諸々参考url!忘れたらここを見よう
https://zenn.dev/ogakuzuko/articles/react-typescript-for-beginner


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


## 関数の定義について
```
type IsPositiveFunc = (arg: number) => boolean;

//関数の型はこのように(引数名: 型) => 返り値の型という形で書くことができます。型システム上、型にかかれている引数名（arg）に意味はありません。

また、interfaceの場合、

interface IsPositiveFunc ={
    number:booleran
}

ともかける
```

## ジェネリクスについて
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
