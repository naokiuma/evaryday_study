## Promise async awaitについて


Promiseはオブジェクト。<br>
以下のメソッドを持っている<br>
then: 成功したときの処理<br>
catch: 失敗したときの処理<br>
メソッドチェーン(henで繋ぐ)が使える<br>

async awaitはpromiseのシンタックスシュガー。<br>
promiseオブジェクトを返してくれる。
asyncで書いたものは、promiseを返してくれる。

```
const order = async mealName => {
  console.log(`オーダー: ${mealName}`);

  if (soup.exists()) {
    // スープがあったら
    return cook(mealName); // 作ってreturn → thenのコールバックに渡る
  } else {
    throw new Error('スープないぜ'); // catchのコールバックに渡る
  }
};
```

await は、async functionの中でawait <Promise>と書くことで、<br>非同期処理の同期処理的な記述を実現します。
(あくまでもシンタックスシュガーなので、実際に扱っているのは非同期処理である Promise)<br>
    
    

awaitは asyncの中でだけ使える。<br>
が、今後トップレベルで使うことができる。そうすれば、下記のコードでmain関数を作らなくても即時に実行できるようになると思われる。<br>
例：https://mebee.info/2022/03/02/post-57753/

```
const getUser = async (userId) => {
  const response = await fetch(
    `https://jsonplaceholder.typicode.com/users/${userId}`,
  );

  if (!response.ok) {
    throw new Error(`${response.status} Error`);
  }

  return response.json();
};

console.log('-- Start --');

const main = async () => {
  try {
    const user = await getUser(2); //ここにユーザー情報が入る
    console.log(user);
  } catch (error) {
    console.error(error);
  } finally {
    console.log('-- Completed --');
  }
};

main();
```

    
## ローカルにnode.jsのサーバーをたて、そこにdockerから通信をするテストをした(503を意図的に返したくて。
が、通信できず。コネクションリフューズ。<br>
dockerは隔離された環境なので、そこからlocalへの通信はできない様子。<br>
https://matsuand.github.io/docs.docker.jp.onthefly/language/golang/run-containers/

## jsの文字列判定でundefinedかどうかを判定する時には 'undefined'ではなく、undefinedで中身を見ること！
※'undefined'　と比較してハマってしまった。。。


## domの変更を監視する(ミューテーションオブザーバー)
親要素を監視対象にし、その中身が変わることを監視する。<br>
https://qiita.com/ryo_hisano/items/9f15ae87d691d497bc17

注意点として、オブザーバーのブロックの中で変更を起こしてしまうと、無限ループに陥る。ifなどで制限をつける必要がある。
```javascript
//head内でjquery読み込み
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>



    <div>
        <button onclick="add_item()">アイテム追加</button>
    </div>
    <div>
        <div id="js_test">
            テストです。この中に複数要素がある。
            <div class="item">
                アイテム１
            </div><!-- /.item -->
            <div class="item">
                アイテム２
            </div><!-- /.item -->
            <div class="item">
                アイテム３
            </div><!-- /.item -->
            <div class="item">
                アイテム４
            </div><!-- /.item -->
        </div><!-- /.js_cast_imgs -->
    </div>

    <script>
        function add_item(){
            let new_dom = `
                <div class="item">
                    アイテム！
                </div>
            `
            $('#js_test').prepend(new_dom);
        }


        //監視対象のdomを指定
        const target = document.getElementById('js_test');
        // オブザーバインスタンスを作成。変化があれば下記が発火する。
        const observer = new MutationObserver((mutations) => {
            console.log('mutationsです。')
            console.log(mutations)
            if($('.js_test').find($('.item'))){
                console.log('アイテムあり。');
                add_item();//ここで追加してしまうと、対象にアイテム追加→検知→また追加、、、と無限ループしてしまう。
            }
        });

        // オブザーバの設定
        const config = {childList: true,subtree: true,attributes:true,};
        // 対象ノードとオブザーバの設定を渡す
        observer.observe(target, config);
    </script>

```
