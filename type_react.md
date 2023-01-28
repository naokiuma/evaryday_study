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

## 関数型プログラミングの各種関数
```
const arr = [1, 2, 3, 4, 5, 6, 7, 8, 9];

console.log(arr.map((n) => n * 2)); // [ 2, 4, 6, 8, 10, 12, 14, 16, 18 ] 
console.log(arr.filter((n) => n % 3 === 0)); // [ 3, 6, 9 ] 
console.log(arr.find((n) => n > 4)); // 5 
console.log(arr.findIndex((n) => n > 4)); // 4 
console.log(arr.every((n) => n !== 0)); // true 
console.log(arr.some((n) => n >= 10)); // false
  
//reduceとsort
const arr = [1, 2, 3, 4, 5];
console.log(arr.reduce((n, m) => n + m)); // 15
console.log(arr.sort((n, m) => n > m ? -1 : 1)); // [ 5, 4, 3, 2, 1 ]


```
・map() …… 対象の配列の要素ひとつひとつを任意に加工した新しい配列を返す<br>
・filter() …… 与えた条件に適合する要素だけを抽出した新しい配列を返す<br>
・find() …… 与えた条件に適合した最初の要素を返す。見つからなかった場合は undefind を返す <br>
・findIndex() …… 与えた条件に適合した最初の要素のインデックスを返す。見つからなかった場 合は -1 を返す <br><br>
・every() ……「与えた条件をすべての要素が満たすか」を真偽値で返す<br>
・some() ……「与えた条件をいずれかの要素が満たすか」を真偽値で返す<br>
  
  
  
