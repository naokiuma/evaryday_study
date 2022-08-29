## const TEST :VFC<Props> = (props) => 。。。における大文字の<Props>とは何を表している？

propsの型定義。こんな感じで使える。
https://github.dev/oukayuka/Riakuto-StartingReact-ja3.1
  
08-componentのCharacterList.tsx参考

type Props = {
  school: string;
  characters: Character[];
};

const CharacterList: VFC<Props> = (props) => {
  const { school, characters } = props;

