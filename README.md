# AI-SaaS Template

このプロジェクトは、LaravelでSaaSサービスを提供するためのテンプレートです。

## 必要要件

- Docker & Docker Compose
- Node.js 18.x以上
- npm 9.x以上

## セットアップ手順

### 1. リポジトリのクローン

```bash
git clone [your-repository-url]
cd ai-saas-template
```

### 2. 環境設定

```bash
cp .env.example .env
```

### 3. バックエンドのセットアップ

```bash
# Dockerコンテナのビルドと起動
docker compose up -d

# 依存パッケージのインストール
docker compose exec app composer install

# アプリケーションキーの生成
docker compose exec app php artisan key:generate

# データベースのマイグレーション
docker compose exec app php artisan migrate

# シードデータの投入
docker compose exec app php artisan db:seed
```

### 4. フロントエンドのセットアップ

```bash
# 依存パッケージのインストール
npm install

# 開発サーバーの起動
npm run dev
```

## デフォルトのログイン情報

セットアップ後、以下のアカウントでログインできます：

### スーパー管理者アカウント
- メールアドレス: `admin@example.com`
- パスワード: `password`
- 権限: システム全体の管理が可能

### デモテナントアカウント
- メールアドレス: `demo@example.com`
- パスワード: `password`
- 権限: 一般的なテナント機能のテストが可能

※ これらは開発環境用のアカウントです。本番環境では必ず変更してください。

## 開発サーバーの起動

このプロジェクトは2つのサーバーを同時に起動する必要があります：

1. **バックエンドサーバー (http://localhost:8000)**
   - Dockerで自動的に起動します
   - APIとデータベースを提供

2. **フロントエンドサーバー (http://localhost:5173)**
   - 以下のコマンドで起動します：
   ```bash
   npm run dev
   ```

## テストの実行

### テスト環境のセットアップ

テストを実行する前に、テスト用のデータベースが作成されていることを確認してください：

```bash
# テスト用データベースの作成
docker exec -it ai-saas-db psql -U postgres -c "CREATE DATABASE testing;"
```

### テストの実行方法

```bash
# 全てのテストを実行
docker compose exec app php artisan test

# 特定のテストファイルを実行
docker compose exec app php artisan test tests/Feature/Auth/LoginTest.php

# 特定のテストメソッドを実行
docker compose exec app php artisan test --filter=test_super_admin_can_authenticate

# テストカバレッジレポートの生成（要Xdebug）
docker compose exec app php artisan test --coverage
```

### テストの種類

1. **機能テスト（Feature Tests）**
   - `tests/Feature` ディレクトリに配置
   - APIエンドポイント、認証、データベース操作などの統合テスト
   - 例：ログイン、ユーザー登録、テナント管理など

2. **単体テスト（Unit Tests）**
   - `tests/Unit` ディレクトリに配置
   - 個々のクラスやメソッドの独立したテスト
   - 例：ユーティリティ関数、サービスクラスなど

### テストの作成

新しいテストファイルを作成する場合：

```bash
# 機能テストの作成
docker compose exec app php artisan make:test UserRegistrationTest

# 単体テストの作成
docker compose exec app php artisan make:test UserServiceTest --unit
```

### CI/CDパイプライン

GitHub Actionsを使用して、以下のタイミングでテストが自動実行されます：

- プルリクエスト作成時
- mainブランチへのマージ時
- リリースタグの作成時

## 技術スタック

- **フロントエンド**
  - React
  - TypeScript
  - Vite
  - Tailwind CSS

- **バックエンド**
  - Laravel 10
  - PostgreSQL
  - Redis

## ライセンス

[MIT License](LICENSE)
