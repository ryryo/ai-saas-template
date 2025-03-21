##############################################
# 計画修正
# マルチテナント＆マルチ機能にする。
もう一つの機能はhello worldするだけのデモログイン機能。動作させない
プランでFREEとか選ばせる形式をやめて、テナントごとに解放機能を選べる。
デモユーザーはhello worldだけ解放。

# スタートアップコマンドを作る
サーバーが立ち上がってなければ立ち上げて、ドキュメントとTodoを確認する
##############################################


# AI-SaaS テンプレート 実装 ToDo リスト

本ドキュメントは、AI-SaaS テンプレートの実装タスクを管理するためのToDoリストです。

## 基本事項
- チェックリストの使い方：タスクが完了したら `-[x]` のように `x` を追加してマークします。
    - [x] 完了時
    - [ ] 未完了時

## 現在のフェーズ: フロントエンド認証の実装

### タスク
- [x] ログインフォームの修正
  - [x] CSRFトークンの設定確認
  - [x] 認証ストアの動作確認
  - [x] エラーハンドリングの実装
- [x] ナビゲーションの条件付き表示の修正
- [x] ルーティングガードの動作確認

### 完了したフェーズ
- [x] Phase 1: 基盤の準備
  - [x] 認証設定の更新（config/auth.php）
  - [x] データベース構造の更新（マイグレーション）

- [x] Phase 2: モデルとスコープの実装
  - [x] TrackingTagモデルの実装
  - [x] TrackingEventモデルの実装
  - [x] TenantSettingモデルの実装
  - [x] SystemSettingモデルの実装

- [x] Phase 3: 認証周りの実装
  - [x] 認証ミドルウェアの更新
  - [x] 認証コントローラーの実装（Login/Register）
  - [x] スーパー管理者ミドルウェアの実装

- [x] Phase 4: APIとリソースの実装
  - [x] TenantResourceの実装
  - [x] TrackingTagResourceの実装
  - [x] TrackingEventResourceの実装
  - [x] TenantSettingResourceの実装
  - [x] SystemSettingResourceの実装
  - [x] APIルートの定義

### 次のフェーズ
- [ ] Phase 5: フロントエンド対応
  - [x] 認証関連のストア更新
  - [x] 型定義の更新
  - [ ] コンポーネントの更新

- [ ] Phase 6: テストとシードデータ
  - [ ] ファクトリーの更新
  - [ ] シーダーの更新
  - [ ] テストの更新

### 直近のタスク
1. [ ] フロントエンドの認証ストアを更新
   - [x] useAuthStore の型定義更新
   - [x] ログイン処理の更新
   - [x] テナント情報の状態管理実装

2. [ ] 認証関連の型定義更新
   - [x] Tenant型の定義
   - [x] API Response型の更新
   - [x] Store State型の更新

3. [ ] 認証関連コンポーネントの更新
   - [ ] ログインフォームの更新
   - [ ] ユーザープロフィール表示の更新
   - [ ] ナビゲーションメニューの更新

---

# 全体のタスクチェックリスト

## 1. プロジェクトセットアップ

### 1.1 開発環境構築
- [x] Laravelプロジェクト作成
- [x] Vue.js + TypeScript 設定
- [x] Docker開発環境構築
- [x] .env ファイル設定
- [x] GitHubリポジトリ設定

### 1.2 ライブラリ・パッケージ導入
- [x] Laravel Sanctum導入（認証）
- [x] Vue 3 + Composition API設定
- [x] Pinia導入（状態管理）
- [x] Tailwind CSS導入
- [x] Vue Router導入
- [x] Axios導入
- [ ] テスト環境構築（PHPUnit, Jest, Cypress）
- [ ] Chart.js導入（グラフ表示）
- [ ] Vee-Validate導入（フォームバリデーション）

## 2. データベース実装

### 2.1 マイグレーション
- [x] tenants テーブル作成
- [x] users テーブル作成
- [x] tracking_tags テーブル作成
- [x] tracking_events テーブル作成
- [x] user_settings テーブル作成
- [x] system_settings テーブル作成

### 2.2 シーダー
- [ ] デモ用テナントデータ作成
- [ ] 初期管理者ユーザー作成
- [ ] テスト用トラッキングタグデータ作成
- [ ] システム設定初期データ作成

### 2.3 モデル
- [x] Tenant モデル作成
- [x] TrackingTag モデル作成
- [x] TrackingEvent モデル作成
- [x] UserSetting モデル作成
- [x] SystemSetting モデル作成
- [ ] AISuggestion モデル作成
- [x] モデル間リレーション設定

### 2.4 マルチテナント実装
- [x] TenantScope グローバルスコープ作成
- [x] テナントミドルウェア作成
- [x] テナント特定ロジック実装

## 3. バックエンド実装

### 3.1 認証機能
- [x] Sanctum設定
- [x] ログイン処理実装
- [x] ログアウト処理実装
- [x] 権限管理（スーパー管理者、テナント管理者）
- [x] APIトークン認証対応

### 3.2 リポジトリパターン実装
- [x] BaseRepository インターフェース作成
- [x] TenantRepository 実装
- [x] UserRepository 実装
- [x] TrackingTagRepository 実装
- [x] TrackingEventRepository 実装
- [x] SettingsRepository 実装

### 3.3 API実装
- [x] テナント管理API実装
- [x] トラッキングタグAPI実装
- [x] トラッキングイベント記録API実装
- [x] ユーザー設定API実装
- [x] システム設定API実装
- [ ] AI分析・提案API実装
- [x] API例外処理・バリデーション実装
- [x] APIレスポンス形式統一

### 3.4 トラッキングシステム実装
- [ ] トラッキングタグJavaScriptコード生成機能
- [ ] イベント受信・検証機能
- [ ] イベントデータ保存・集計機能
- [ ] タグインストール確認機能

### 3.5 AI機能実装
- [ ] OpenAI API連携
- [ ] トラッキングデータ分析ロジック
- [ ] CTA最適化提案生成ロジック
- [ ] レコメンデーション機能実装

### 3.6 キュー・非同期処理
- [ ] イベント処理キュー設定
- [ ] AI分析ジョブ実装
- [ ] キュー監視（Laravel Horizon）設定
- [ ] スケジュールタスク設定

### 3.7 キャッシュ戦略実装
- [ ] Redis設定
- [ ] データキャッシュ実装
- [ ] キャッシュ自動更新仕組み実装

## 4. フロントエンド実装

### 4.1 基盤実装
- [x] Vueプロジェクト構成設定
- [x] TypeScript型定義
- [x] Pinia ストア設計・実装
- [x] Vue Router設定
- [ ] レイアウトコンポーネント作成
- [x] API連携モジュール実装
- [ ] 認証ロジック実装
- [ ] グローバルコンポーネント登録

### 4.2 UIコンポーネント実装
- [ ] shadcn/uiのセットアップ 
- [ ] 認証関連コンポーネント
  - [ ] ログインフォーム
  - [ ] ユーザープロフィール
- [ ] ナビゲーションメニュー
  - [x] サイドメニュー（折りたたみ機能付き）
  - [x] ヘッダーメニュー
  - [x] モバイルメニュー
- [ ] 共通コンポーネント
  - [ ] ボタン
  - [ ] フォーム入力
  - [ ] テーブル
  - [ ] ページネーション
  - [ ] モーダル
  - [ ] アラート・通知
  - [ ] KPIカード
  - [ ] ローディングインジケータ
  - [ ] タブパネル
  - [ ] アコーディオン
  - [ ] ドロップダウン
  - [ ] 日付ピッカー
- [ ] グラフコンポーネント
  - [ ] 折れ線グラフ
  - [ ] 棒グラフ
  - [ ] カスタムチャート

### 4.3 画面実装
- [x] ランディングページ（LP）
- [ ] ログイン画面
- [ ] ダッシュボード
  - [ ] スーパー管理者ダッシュボード
  - [ ] テナント管理者ダッシュボード
- [ ] テナント管理画面
  - [ ] テナント一覧
  - [ ] テナント作成/編集
  - [ ] テナント詳細
- [ ] ユーザー管理画面
  - [ ] ユーザー一覧
  - [ ] ユーザー作成/編集
  - [ ] ユーザー詳細
- [ ] トラッキングタグ管理画面
  - [ ] タグ一覧
  - [ ] タグ作成/編集
  - [ ] タグ設置コード表示
  - [ ] タグステータス管理
- [ ] トラッキングデータ分析画面
  - [ ] リアルタイムデータ表示
  - [ ] 集計データグラフ
  - [ ] フィルタリング機能
  - [ ] 期間指定機能
- [ ] AI提案画面
  - [ ] CTA最適化提案表示
  - [ ] 新規分析リクエスト
- [ ] 設定画面
  - [ ] ユーザー設定
  - [ ] システム設定
  - [ ] テーマ設定
- [ ] ヘルプ・ガイド画面

### 4.4 カラースキーマ・テーマ実装
- [ ] カスタムテーマ
- [ ] テーマ切替機能

## 5. トラッキングタグ（JavaScript）実装

### 5.1 クライアント実装
- [ ] 軽量ローダースクリプト作成
- [ ] 非同期ロードロジック実装
- [ ] イベントリスナー実装
  - [ ] クリックイベント
  - [ ] フォーム送信イベント
  - [ ] 表示イベント
  - [ ] スクロールイベント
- [ ] データ収集モジュール実装
- [ ] データ送信モジュール実装
  - [ ] Beacon API対応
  - [ ] XHR フォールバック
  - [ ] オフライン対応
  - [ ] バッファリング機能
  - [ ] リトライロジック
- [ ] エラーハンドリング

### 5.2 クロスブラウザ対応
- [ ] Chrome対応
- [ ] Firefox対応
- [ ] Safari対応
- [ ] Edge対応
- [ ] iOS Safari対応
- [ ] Android Chrome対応

## 6. テスト実装

### 6.1 単体テスト
- [ ] PHPUnit設定
- [ ] Jest設定
- [x] モデルテスト実装
  - [x] Tenantモデルテスト
    - [x] テナント作成テスト
    - [x] テナント削除テスト（ソフトデリート）
    - [x] リレーション（users, tracking_tags, tracking_events）テスト
  - [x] TrackingTagモデルテスト
    - [x] タグ作成テスト
    - [x] UUID自動生成テスト
    - [x] リレーション（tenant, user, tracking_events）テスト
  - [x] TrackingEventモデルテスト
    - [x] イベント作成テスト
    - [x] JSON/配列型キャストテスト
    - [x] リレーション（tenant, tracking_tag）テスト
  - [x] UserSettingモデルテスト
    - [x] 設定作成テスト
    - [x] JSON型キャストテスト
    - [x] リレーション（user）テスト
  - [x] SystemSettingモデルテスト
    - [x] 設定作成テスト
    - [x] JSON型キャストテスト
    - [x] テナント設定可能フラグテスト
- [ ] コントローラーテスト実装
- [ ] サービステスト実装
- [ ] Vue コンポーネントテスト実装
- [ ] ストアテスト実装
- [ ] ユーティリティテスト実装

### 6.2 統合テスト
- [ ] API統合テスト実装
- [ ] コンポーネント統合テスト実装
- [ ] マルチテナント分離テスト実装

### 6.3 E2Eテスト
- [ ] Cypress設定
- [ ] 認証フローテスト実装
- [ ] テナント管理フローテスト実装
- [ ] トラッキングタグ管理フローテスト実装
- [ ] トラッキングイベント記録テスト実装
- [ ] データ分析フローテスト実装
- [ ] API契約テスト実装

### 6.4 パフォーマンステスト
- [ ] パフォーマンス計測設定
- [ ] ページロード時間テスト実装
- [ ] API応答時間テスト実装
- [ ] 同時ユーザーアクセステスト実装
- [ ] 負荷テスト実装

### 6.5 セキュリティテスト
- [ ] 認証・認可テスト実装
- [ ] クロスサイトスクリプティング対策テスト
- [ ] CSRF対策テスト
- [ ] SQLインジェクション対策テスト
- [ ] レート制限テスト

## 7. デプロイ・インフラ

### 7.1 Laravel Forge設定
- [ ] サーバープロビジョニング
- [ ] Nginx設定
- [ ] PHP-FPM設定
- [ ] PostgreSQL設定
- [ ] Redis設定
- [ ] SSL証明書設定
- [ ] デプロイスクリプト作成

### 7.2 CI/CD
- [ ] GitHub Actions ワークフロー作成
  - [ ] テスト実行
  - [ ] コード静的解析
  - [ ] ビルド
  - [ ] デプロイ
- [ ] 自動デプロイ設定

### 7.3 監視・ロギング
- [ ] アプリケーションログ設定
- [ ] エラー監視設定
- [ ] パフォーマンス監視設定
- [ ] サーバー監視設定
- [ ] ユーザーアクティビティログ設定

## 8. ドキュメント作成

### 8.1 技術ドキュメント
- [ ] セットアップガイド
- [ ] API仕様書
- [ ] コンポーネントスタイルガイド
- [ ] コードコメント・PHPDoc
- [ ] アーキテクチャ説明
- [ ] データベース構造説明
- [ ] テスト実行手順

### 8.2 ユーザードキュメント
- [ ] 管理者マニュアル
- [ ] ユーザーマニュアル
- [ ] トラッキングタグ設置ガイド
- [ ] よくある質問（FAQ）

## 9. リリース準備

### 9.1 最終チェック
- [ ] 全テスト実行・合格確認
- [ ] パフォーマンス要件達成確認
- [ ] セキュリティ要件達成確認
- [ ] ユーザビリティ要件達成確認
- [ ] すべてのドキュメント完成確認
- [ ] すべての受入基準達成確認

### 9.2 リリース
- [ ] 本番環境デプロイ
- [ ] 動作確認
- [ ] 最終調整
- [ ] GitHub公開設定
- [ ] リリースノート作成

## 10. プロジェクト管理

### 10.1 コードレビュー
- [ ] コードレビューガイドライン作成
- [ ] レビュープロセス確立
- [ ] Pull Requestテンプレート作成 