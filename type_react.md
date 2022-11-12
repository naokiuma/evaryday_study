## const TEST :VFC<Props> = (props) => 。。。におけるVFCの横の大文字のPropsとは何を表している？

propsのtypeによる型定義。こんな感じで使える。
https://github.dev/oukayuka/Riakuto-StartingReact-ja3.1
  
08-componentのCharacterList.tsx参考

パターン１
type Props = {
  school: string;
  characters: Character[];
};

const CharacterList: VFC<Props> = (props) => {
  const { school, characters } = props;

 
パターン２
export const TopicForm:FC<{isActive:boolean}> = memo((props) => {
こんな感じで子コンポーネントて定義。
親はこういうふうに渡せる
<TopicForm isActive={true} />


