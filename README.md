## New Warzone-Aoe プロジェクト
既存のサイト「[Warzone Rating System](http://warzone.php.xdomain.jp/)」をリニューアルする目的で立ち上げを行いました。

## 技術スタック
- フロントエンド
  - Vue.js
  - Vuetify
- バックエンド
  - Laravel
- アーキテクチャー
  - ドメイン駆動設計
- DB
  - MySQL
- クラウド基盤
  - Heroku
  - Docker

## 構築手順
※当プロジェクトでは、Macでの開発を基準にしております。

Dockerを使用するため、Windowsで開発を行う場合は、

WSL2にDockerエンジンをインストールする準備をしてください。

```
$ git clone https://github.com/sokorahen-szk/warzone-aoe.git
```

## Docker開発環境構築
```
$ cp /path/to/warzone-aoe/infra

## VirtualBoxを使用してる場合はVMを新しく作る
$ docker-machine create wzn
$ eval "$(docker-machine env wzn)"

$ docker-compose up -d --build
```

## composer install
```
$ cd /path/to/warzone-aoe/backend

docker exec web composer install
```

## npm install
```
$ cd /path/to/warzone-aoe/backend

# nodeとnpmのバージョンを合わせて下さい。
# npm -v
# 6.10.2
# node -v
# v12.8.0

npm i
```

## .envやkeyのgenerate
```
$ cd /path/to/warzone-aoe/backend

$ cp ./.env.example ./.env

$ php artisan key generate

$ php artisan jwt:secret
```

## migration
```
$ docker exec web php artisan migrate:refresh --seed
```

## npm run development
```
$ cd /path/to/warzone-aoe/backend

$ npm run development

```

## storage link
```
# これをやらないと画像が表示できない
$ docker exec web php artisan storage:link
```

## hostsに登録
```
$ docker-machine ls
wzn             *        virtualbox   Running   tcp://xxx.xxx.xxx.xxx:2376           v19.03.12

xxx.xxx.xxx.xxxのIPをhostsに登録します。
```
`sudo vi /etc/hosts`
```
xxx.xxx.xxx.xxx  vm.warzone-aoe.jp
```