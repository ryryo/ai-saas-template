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
