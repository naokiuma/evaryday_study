# ruby環境について
macではデフォルトで入っているが、基本古い。<br>
rbenvでバージョン指定してのインストールが可能

https://github.com/rbenv/rbenv
```
//まずはbrewでrbenvをインスト

brew install rbenv ruby-build

//rubyを開始
rbenv init

//案内に従い、環境変数パスを通す
echo 'eval "$(rbenv init - zsh)"' >> ~/.zshrc

//ようやくバージョン指定してインストール
rbenv install 3.2.2

//利用するバージョンを変更
rbenv global 2.7.4

```
