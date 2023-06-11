## 関数のカリー化
```
// mを引数によって、m*nを返す関数。使う時にはカッコ二つ。()()となる。
  const withMultiple = (n) => {
    return (m) => n * m;
  };
  console.log(withMultiple(2)(4));
```

## シングルトンと、privateコンストラクタとは？
シングルトンパターンとは・・・一つのオブジェクトしか存在できないようにする。
例えば、会計部門は会社には一つしかないので、一つだけにしたい。

コンストラクタは、privateにする。
そしてそのinstaceもprivate、staticなものにする。

```
class AccountingDepartment {
	id:string
	private static instance:AccountingDepartment //instanceは自分自身なので、型は
	
	private constructor(){
	
	
	static getInstance(){
		if(this.instatce){ //ここでのthisは、class自体を指す。なので、staticなプロパティ、instanceにアクセスできる。
			return thiis.instance;
		}
		//もしスタティックがなければ、作り、返す。
		this.instance = new AccountingDepartment
		return this.instance;
	}
}

//作り方
const accounting = AccountingDepartment.getInstance();
```



## 抽象クラスについて
関数などのオーバーライドを強制させる機能は。。。抽象。
抽象クラスはメソッドの実装はしない。型などだけ設定する。

```
abstract 関数名():void
//実装は行わないこと。
```
抽象クラスはnewでインスタンスを作ることはできないので注意。


## 継承などについて
・extensで継承したサブクラスには、super を実行することで、親クラスのコンストラクタを異実行する
・アクセス修飾子の「private」は、そのクラスからのみアクセスできる。protectedは、そのクラスと、その子どもクラスからのみアクセスできる。
・get、setは、private変数でもアクセスができるもの。
・statilメソッドを作れば、インスタンス化しなくてもメソッドを使うことができる。逆に、インスタンス化したオブジェクトからかはアクセスできない。

## jsのclassでは、コンストラクタで明示的に引数を書けば、this.name...とかしなくても良い。
```
class Department {
	id:string
	name:string
  // ↑これとか、コンストラクタの中でのthis.id。。。とかはがめんどくさいので、、、
  // ↓こう書く！そうすればクラスのプロパティ変数にすることができる。

	constructor(private id:string,public n:string){
		this.id = id //これも要らなくなる１
		this.name = n 
	}

}

let salse = new Department('1','sales');
//セクション5の小テスト４あたりを参考に。
```


## javascriptのclassには、publicとprivateはない。
ただ、tsはその辺りを判断してくれるので、クリーンなコードを書くことができる。

## レストパラメータ
```
const add = (...numbers:number[]) =>{
  let result = 0;

  //reduceは各要素を足し算するのに便利。
  //初期値が0、curResultは現在の数字、curValueは現在の要素
  return numbers.reduce((curResult,curValue) => {
    return curResult + curValue;
  },0);
};


console.log(add(5,10,20,3))

const result = add(5,10,20,3)
結果は、38!
```

## スプレッド演算子
```
test = ['rice','pan']
test2 = ['takoyaki']

test2.push(...test)
//とかけば、testの中身が展開されて、それぞれpushされる
```

## jsで配列内のオブジェクトも見たい時
```
console.dir(変数,{depth: null})
```
でok


## jsで2進数、8進数、16進数とか「5..toString()」とか。
jsでそれぞれ表現したい場合は、0b、0o、0xをつける。
```
0b1010 // 2進数
0o755 // 8進数
0xfff // 16進数
```

数値リテラルを参照する場合、小数点なのか、プロパティアクセッサーなのかがわからないため、
```
5.toString(); // この書き方は構文エラー
//↑ではなく、↓こうかく
5..toString();
(5).toString();
```



## ボックス化とラッパーオブジェクトとは？
通常、プリミティブ型にはプロパティがない。
が、jsのプリミティブ型は、プロパティを持ったオブジェクトとして扱うことができる。
  
```
"name".length; //4
```
など。このように、プリミティブ型をまるでオブジェクトのように扱えるのはJavaScriptの特徴。 <br>
プリミティブ型をオブジェクトに自動変換（ラッパーオブジェクトを使っている。）する機能をオートボクシング(autoboxing)、自動ボックス化と呼ぶ。<br>
MDNで、「Number.prototype.toString()」などの、prototypeとはなんなのか？の答えである。
https://typescriptbook.jp/reference/values-types-variables/boxing
<br><br>
なお、tsでは型注釈をするときにラッパーオブジェクトの指定はできるが、特に利点はないので、プリミティブ型を使おう。


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

