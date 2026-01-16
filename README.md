# Viajero（旅程表アプリ）

Viajero はスペイン語で「旅人」を意味します。
このアプリは、単なるスケジュール管理ではなく、
旅人が旅を組み立てていくプロセスを大切にしたいという思いから名付けました。

旅行計画（Trip）と旅程（Itinerary）を管理できる Web アプリケーションです。
Laravel の MVC 構造・CRUD 処理・認証・リレーション設計を意識して開発しています。

---
## 概要

旅行ごとに旅程（行動予定）を時系列で管理
時刻を入力すると、morning / noon / evening に自動分類
旅程の作成・編集・削除・並び替えが可能
ログインユーザーごとにデータを安全に管理

---
### 学習目的

Laravel の CRUD / MVC / ルーティング / 認証を実践的に理解
Docker + Sail を使った開発環境構築に慣れる
Blade + Tailwind CSS による UI 実装

---
## 技術スタック
### 言語
PHP 8.x

HTML / CSS

JavaScript（最小限）

---
### フレームワーク / ライブラリ
Laravel 10

Laravel Breeze（認証）

Blade（テンプレートエンジン）

Tailwind CSS（UI）

---
### 開発環境・ツール
Docker

Laravel Sail

MySQL

Git / GitHub

---
## アーキテクチャ（CRUD / MVC 対応表）
### MVC 構成
役割	対象
Model	Trip / Itinerary
View	Blade（trips/, itineraries/）
Controller	TripController / ItineraryController
### CRUD 対応箇所
Trip（旅行）
操作	対応
Create	trips.create / trips.store
Read	trips.index / trips.show
Update	trips.edit / trips.update
Delete	trips.destroy
### Itinerary（旅程）
操作	対応
Create	itineraries.create / itineraries.store
Read	trips.show 内で一覧表示
Update	itineraries.edit / itineraries.update
Delete	itineraries.destroy

---
## こだわって実装した機能
① 時刻による時間帯自動分類
時刻を入力すると以下のように自動分類

morning：05:00〜10:59

noon：11:00〜16:59

evening：17:00〜23:59

データは壊さず、表示ロジックのみで制御

② 15分刻みの時刻入力
<input type="time" step="900">

UX を意識し、不要な細かい時間指定を防止

③ 編集画面で既存データを保持
日付・時刻・内容が編集画面で事前入力された状態で表示

「何を修正しているか」が一目で分かる UI

④ 認証・認可（403 / 404 制御）
自分以外の Trip / Itinerary にはアクセス不可

Controller でユーザー確認を実装

abort_if($itinerary->trip->user_id !== Auth::id(), 403);

---
## 使い方

新規登録 or ログイン

旅行（Trip）を作成

旅程（Itinerary）を追加

時刻・メモ・移動情報を管理

編集・削除・並び替えで調整

---
## セットアップ方法（コピペOK）
1. リポジトリをクローン
git clone https://github.com/yourname/viajero.git
cd viajero

2. 環境変数を設定
cp .env.example .env

3. Docker（Sail）起動
./vendor/bin/sail up -d

4. 依存関係 & 初期設定
./vendor/bin/sail composer install
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate

5. アクセス
http://localhost

---
## 今後の改善予定（Optional）
Google Maps API 連携

スマホ対応 UI の強化

共有機能（Read Only）
