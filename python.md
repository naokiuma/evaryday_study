# split関数
値を引数の値で分割し、リスト（配列）にする。引数がない場合は
s.split(',') # 文字列 s を , (カンマ) 区切りで分割

## 多重代入
代入文の左辺と右辺に、対応する複数の変数や式を指定する、多重代入を行うことができます。たとえば、以下のプログラムは１行に入力された２つの文字列をスワップして出力します。 

```
a,b = input().split() # Hello World　と入力する
a,b = b,a
print(a, b)           # World Hello　と出力される
```

## map関数
 map関数は以下のような書式で、第一引数に関数、第二引数にシーケンス（リスト）を指定します。 
 
 ```
 l = ["1", "2", "3"]       #　３つの文字列要素
print(l[0] + l[1] + l[2]) # 123 （文字列として計算される）

l = list(map(int, l)) #map関数により、intに変換したlistにする。 
print(l[0] + l[1] + l[2]) # 6　（整数として計算される）

# 基本はこれで受け取るのが良さそう。
a,b,c = map(int,input().split())

 ```
 
 
 ## if文
 
 ```
 
if A:
    print("Yes")
elif B:
    print("fo")
else:
    print("No")
    
 ```
 ## 演算子
 基本的にphpやjsと大きくは変わらないが、
 /（割り算） は 実数がかえり、 // は整数部分のみかえる


メモ
https://onlinejudge.u-aizu.ac.jp/courses/lesson/2/ITP1/2/ITP1_2_A
マイナスの値を考慮していない

## 標準入力で一行ずつ処理する方法
下記で1行ずつすすむ
```
while True:
    x = int(input())
    if x == 0:
        break
    print(x)
```
