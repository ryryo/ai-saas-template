# ディレクトリ構成

以下のディレクトリ構造に従って実装を行ってください：

```
project/
├── app/                    # Laravelアプリケーションコード
│   ├── Console/           # Artisanコマンド
│   ├── Exceptions/        # 例外ハンドラー
│   ├── Http/              
│   │   ├── Controllers/   # コントローラー
│   │   ├── Middleware/    # ミドルウェア
│   │   └── Requests/      # フォームリクエスト
│   ├── Models/            # Eloquentモデル
│   ├── Providers/         # サービスプロバイダー
│   ├── Repositories/      # リポジトリクラス
│   └── Services/          # サービスクラス
├── bootstrap/             # フレームワーク起動ファイル
├── config/                # 設定ファイル
├── database/              # データベース関連
│   ├── factories/         # モデルファクトリー
│   ├── migrations/        # マイグレーション
│   └── seeders/          # シーダー
├── docker/                # Docker設定
├── docs/                  # ドキュメント
│   ├── startup/          # 初期設計書
│   └── design/           # 追加設計書
├── public/                # 公開ディレクトリ
│   └── build/            # コンパイル済みアセット
├── resources/             # フロントエンドリソース
│   ├── css/              # スタイルシート
│   ├── js/               # Vueコンポーネント
│   │   ├── components/   # コンポーネント
│   │   │   ├── atoms/    # 原子コンポーネント
│   │   │   │   ├── buttons/     # ボタン
│   │   │   │   ├── inputs/      # 入力フィールド
│   │   │   │   ├── icons/       # アイコン
│   │   │   │   └── typography/  # テキスト要素
│   │   │   ├── molecules/  # 分子コンポーネント
│   │   │   │   ├── forms/       # フォーム
│   │   │   │   ├── cards/       # カード
│   │   │   │   └── lists/       # リスト
│   │   │   ├── organisms/  # 有機体コンポーネント
│   │   │   │   ├── headers/     # ヘッダー
│   │   │   │   ├── sidebars/    # サイドバー
│   │   │   │   ├── tables/      # テーブル
│   │   │   │   └── modals/      # モーダル
│   │   │   └── templates/  # テンプレート
│   │   │       ├── layouts/     # レイアウト
│   │   │       └── sections/    # セクション
│   │   ├── composables/  # コンポジション関数
│   │   ├── pages/        # ページコンポーネント
│   │   ├── router/       # Vue Router設定
│   │   └── stores/       # Piniaストア
│   └── views/            # Bladeテンプレート
├── routes/                # ルート定義
│   ├── api.php           # APIルート
│   ├── channels.php      # ブロードキャストチャネル
│   ├── console.php       # コンソールルート
│   └── web.php           # Webルート
├── storage/               # アプリケーションストレージ
├── tests/                 # テストコード
│   ├── Feature/          # 機能テスト
│   └── Unit/             # 単体テスト
└── vendor/                # Composer依存パッケージ
```

### 配置ルール
- コントローラー → `app/Http/Controllers/`
  - API用 → `app/Http/Controllers/Api/`
  - Web用 → `app/Http/Controllers/Web/`
- Vueコンポーネント → `resources/js/components/`
  - Atomic Design構造：
    - atoms → 最小単位のUI要素（ボタン、入力フィールド等）
    - molecules → atomsを組み合わせた小規模なコンポーネント
    - organisms → moleculesを組み合わせた機能的なコンポーネント
    - templates → organismsを配置したページテンプレート
    - pages → 実際のページコンポーネント
- APIルート → `routes/api.php`
- 共通処理 → `app/Services/`
- リポジトリ → `app/Repositories/`
- テスト → `tests/Feature/` または `tests/Unit/`