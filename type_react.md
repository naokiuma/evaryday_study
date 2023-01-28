## ジェネリクスについて
```
# 変数
const numbers:number[]=[1,2,3]
という書き方もできるし、
const numbers:Array<string> = ['one','two',three']
という書き方もできる。

# 関数の型宣言

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

## const TEST :VFC<Props> = (props) => 。。。におけるVFCの横の大文字のPropsとは何を表している？

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
