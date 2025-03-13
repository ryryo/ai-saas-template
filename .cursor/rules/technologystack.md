# 技術スタック

## コア技術
- PHP: ^8.2
- Node.js: ^20.0.0
- TypeScript: ^5.3.3

## フロントエンド
- Vue.js: ^3.4.19
- Vue Router: ^4.3.0
- Pinia: ^2.1.7
- Tailwind CSS: ^4.0.0
- Vite: ^6.0.11

## バックエンド
- Laravel: ^12.0
- Laravel Sanctum: ^4.0
- Laravel Tinker: ^2.10.1

## 開発ツール
- npm: ^10.0.0
- Composer: ^2.0
- PHPUnit: ^11.5.3
- Laravel Pint: ^1.13
- Laravel Sail: ^1.41
- Laravel Pail: ^1.2.2

---

# コーディング規約

## PHP/Laravel
- PSR-12に準拠
- Laravelのコーディングスタイルガイドに従う
- PHPDocによるドキュメントコメントを記述
- 命名規則：
  - コントローラー: 単数形、PascalCase (例: UserController)
  - モデル: 単数形、PascalCase (例: User)
  - マイグレーション: スネークケース (例: create_users_table)
  - テーブル名: 複数形、スネークケース (例: users)
  - ルート: スネークケース
  - 変数: キャメルケース (例: $userName)
- リポジトリパターンの採用
- マルチテナント対応：
  - テナント関連テーブルには「tenant_id」カラムを含める
  - Eloquentのグローバルスコープを活用

## Vue.js/TypeScript
- Composition APIの使用
- TypeScriptの厳格な型チェック
- SFC（Single File Component）形式
- JSDoc/TSDocによるドキュメントコメント
- Piniaによる状態管理
- 命名規則：
  - コンポーネント: PascalCase (例: UserProfile.vue)
  - コンポジション関数: camelCaseで'use'プレフィックス (例: useUserData)
  - 関数/変数: camelCase (例: getUserData)
  - 定数: UPPER_SNAKE_CASE (例: API_ENDPOINT)
  - ファイル名: コンポーネントはPascalCase、その他はkebab-case

## CSS/Tailwind
- TailwindCSSのユーティリティクラスを活用
- コンポーネント固有のスタイルはScopedCSS
- カラースキーマの変数化
- レスポンシブデザインの考慮
- アクセシビリティへの配慮

---

# API設計規約

## 基本方針
- RESTful APIの設計原則に従う
- APIバージョニングはURIベース（例：`api/v1/...`）
- 認証はSanctumを使用
- レスポンスフォーマットの一貫性を保持
- 環境変数は.envファイルで管理

## エンドポイント設計
- 複数形の名詞を使用（例: /api/users）
- 適切なHTTPメソッドの使用：
  - GET: リソースの取得
  - POST: リソースの作成
  - PUT/PATCH: リソースの更新
  - DELETE: リソースの削除

## 重要な制約事項
- APIルートは `routes/api.php` で一元管理
- APIミドルウェアは `app/Http/Middleware` で管理
- 変更禁止ファイル（承認必要）：
  - config/sanctum.php  - API認証の設定
  - config/cors.php    - CORS設定の一元管理
  - .env.example      - 環境変数の定義

---

# テストコード規約

## バックエンドテスト
- PHPUnitを使用
- Feature テストと Unit テストを適切に分離
- データベーステストには `RefreshDatabase` トレイトを使用
- ファクトリーを活用したテストデータ生成

## フロントエンドテスト
- Vitest/Jestを使用
- Vue Test Utilsによるコンポーネントテスト
- テストカバレッジの意識

## テストの配置
- Feature テスト → `tests/Feature/`
- Unit テスト → `tests/Unit/`
- コンポーネントテスト → `tests/Components/`