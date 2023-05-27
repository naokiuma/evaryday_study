## ts基本の諸々参考url!忘れたらここを見よう
https://zenn.dev/ogakuzuko/articles/react-typescript-for-beginner


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


## ジェネリクスについて
```
# 変数
const numbers:number[]=[1,2,3]
という書き方もできるし、
const numbers:Array<string> = ['one','two',three']
という書き方もできる。
```

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
