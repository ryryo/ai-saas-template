# API設計

本ドキュメントでは、AI-SaaS テンプレートのAPI設計について説明します。RESTful APIの原則に従い、JSON形式でデータをやり取りします。

## 1. API設計の基本方針

### 1.1 認証の考え方

- **現在の実装**
  - テナントを認証の主体として扱う
  - 1テナント＝1管理者の単純な構造を採用
  - テナント情報に認証・権限情報を直接含める

- **将来の拡張性**
  - テナント内での複数ユーザー管理への拡張を想定
  - 現時点では「テナント」という用語で統一
  - 将来的なユーザー管理APIの追加に対応できる設計
  - APIレスポンスは拡張性を考慮した構造

### 1.2 認証方式

Laravel Sanctumを使用したSPA認証を採用します。

```mermaid
sequenceDiagram
    actor User as ユーザー
    participant Frontend as Vue.js
    participant Auth as Laravel Sanctum
    participant API as Laravel API
    
    User->>Frontend: ログイン情報入力
    Frontend->>Auth: POST /api/login
    Auth-->>Frontend: CSRF Cookie + セッション認証
    Frontend->>API: APIリクエスト (with Cookie)
    API-->>Frontend: レスポンス
```

### 1.3 認証エンドポイント

| エンドポイント | メソッド | 説明 |
|--------------|---------|------|
| `/api/login` | POST | ユーザーログイン |
| `/api/logout` | POST | ユーザーログアウト |
| `/api/user` | GET | 認証済みユーザー情報取得 |

### 1.4 APIトークン

モバイルアプリやサードパーティ連携用に、APIトークン認証も提供します。

```
Authorization: Bearer {api_token}
```

## 2. エンドポイント一覧

### 2.1 テナント管理 API

| エンドポイント | メソッド | 説明 | アクセス権限 |
|--------------|---------|------|------------|
| `/api/tenants` | GET | テナント一覧取得 | super_admin |
| `/api/tenants` | POST | テナント作成 | super_admin |
| `/api/tenants/{id}` | GET | テナント詳細取得 | super_admin, 本人* |
| `/api/tenants/{id}` | PUT | テナント更新 | super_admin, 本人* |
| `/api/tenants/{id}` | DELETE | テナント削除 | super_admin |
| `/api/tenants/{id}/settings` | GET | テナント設定取得 | super_admin, 本人* |
| `/api/tenants/{id}/settings` | PUT | テナント設定更新 | super_admin, 本人* |
| `/api/tenants/{id}/password` | PUT | パスワード更新 | super_admin, 本人* |
| `/api/tenants/{id}/email` | PUT | メールアドレス更新 | super_admin, 本人* |

*本人とは、該当のテナントIDを持つテナント自身を指します

注: 将来的なマルチユーザー対応時には、ユーザー管理APIを追加予定です。現時点では各テナントが直接認証の主体となります。

### 2.2 トラッキングタグ API

| エンドポイント | メソッド | 説明 | アクセス権限 |
|--------------|---------|------|------------|
| `/api/tracking-tags` | GET | タグ一覧取得 | 認証済みユーザー* |
| `/api/tracking-tags` | POST | タグ作成 | 認証済みユーザー* |
| `/api/tracking-tags/{id}` | GET | タグ詳細取得 | 認証済みユーザー* |
| `/api/tracking-tags/{id}` | PUT | タグ更新 | 認証済みユーザー* |
| `/api/tracking-tags/{id}` | DELETE | タグ削除 | 認証済みユーザー* |
| `/api/tracking-tags/{id}/code` | GET | タグ設置コード取得 | 認証済みユーザー* |

*自分のテナントのタグのみアクセス可能

### 2.3 トラッキングイベント API

| エンドポイント | メソッド | 説明 | アクセス権限 |
|--------------|---------|------|------------|
| `/api/tracking-events` | POST | イベント記録 | 公開API（タグキー認証） |
| `/api/tracking-events` | GET | イベント一覧取得 | 認証済みユーザー* |
| `/api/tracking-events/stats` | GET | イベント統計取得 | 認証済みユーザー* |
| `/api/tracking-events/export` | GET | イベントデータエクスポート | 認証済みユーザー* |

*自分のテナントのイベントのみアクセス可能

### 2.4 AI分析・提案 API

| エンドポイント | メソッド | 説明 | アクセス権限 |
|--------------|---------|------|------------|
| `/api/ai/analyze` | POST | トラッキングデータ分析 | 認証済みユーザー* |
| `/api/ai/suggestions` | GET | AI提案一覧取得 | 認証済みユーザー* |
| `/api/ai/suggestions/{id}` | GET | AI提案詳細取得 | 認証済みユーザー* |

*自分のテナントのデータのみアクセス可能

### 2.5 システム設定 API

| エンドポイント | メソッド | 説明 | アクセス権限 |
|--------------|---------|------|------------|
| `/api/settings` | GET | システム設定一覧取得 | super_admin |
| `/api/settings` | PUT | システム設定一括更新 | super_admin |
| `/api/settings/{key}` | GET | 特定設定取得 | super_admin |
| `/api/settings/{key}` | PUT | 特定設定更新 | super_admin |

## 3. リクエスト/レスポンス仕様

### 3.1 共通ヘッダー

#### リクエストヘッダー

```
Accept: application/json
Content-Type: application/json
X-CSRF-TOKEN: {csrf_token}  // Cookie認証時
Authorization: Bearer {api_token}  // トークン認証時
```

#### レスポンスヘッダー

```
Content-Type: application/json
X-RateLimit-Limit: {rate_limit}
X-RateLimit-Remaining: {remaining_requests}
```

### 3.2 共通レスポンス形式

#### 成功レスポンス

```json
{
  "success": true,
  "data": {
    // レスポンスデータ
  },
  "meta": {
    // ページネーション情報など
  }
}
```

#### エラーレスポンス

```json
{
  "success": false,
  "error": {
    "code": "error_code",
    "message": "エラーメッセージ",
    "details": {
      // 詳細エラー情報
    }
  }
}
```

### 3.3 ステータスコード

| コード | 説明 |
|-------|------|
| 200 | OK - リクエスト成功 |
| 201 | Created - リソース作成成功 |
| 204 | No Content - 成功（返却データなし） |
| 400 | Bad Request - リクエスト不正 |
| 401 | Unauthorized - 認証エラー |
| 403 | Forbidden - 権限エラー |
| 404 | Not Found - リソース未発見 |
| 422 | Unprocessable Entity - バリデーションエラー |
| 429 | Too Many Requests - レート制限超過 |
| 500 | Internal Server Error - サーバーエラー |

### 3.4 ページネーション

一覧取得APIはページネーションをサポートします。

#### リクエストパラメータ

```
/api/users?page=2&per_page=15
```

#### レスポンス

```json
{
  "success": true,
  "data": [
    // ユーザーデータの配列
  ],
  "meta": {
    "current_page": 2,
    "per_page": 15,
    "total": 45,
    "total_pages": 3
  },
  "links": {
    "first": "/api/users?page=1&per_page=15",
    "prev": "/api/users?page=1&per_page=15",
    "next": "/api/users?page=3&per_page=15",
    "last": "/api/users?page=3&per_page=15"
  }
}
```

### 3.5 フィルタリングとソート

一覧取得APIはフィルタリングとソートをサポートします。

```
/api/tracking-events?filter[event_type]=click&sort=-created_at
```

## 4. 主要エンドポイント詳細

### 4.1 ログイン

#### リクエスト

```
POST /api/login
```

```json
{
  "email": "tenant@example.com",
  "password": "password"
}
```

#### レスポンス

```json
{
  "tenant": {
    "id": 1,
    "name": "テナント企業名",
    "email": "tenant@example.com",
    "role": "admin",
    "plan_type": "standard",
    "status": "active",
    "last_login_at": "2024-03-14T10:00:00Z"
  }
}
```

※ 将来的なユーザー管理機能追加時は、レスポンス構造を拡張予定

### 4.2 認証済みテナント情報取得

#### リクエスト

```
GET /api/tenant
```

#### レスポンス

```json
{
  "success": true,
  "data": {
    "tenant": {
      "id": 5,
      "name": "テナント名",
      "email": "user@example.com",
      "role": "tenant_admin",
      "plan_type": "premium",
      "status": "active",
      "last_login_at": "2023-03-15T09:30:00Z"
    },
    "settings": {
      "theme": "light",
      "notification_preferences": {
        "email": true,
        "push": false
      }
    }
  }
}
```

### 4.3 ログアウト

#### リクエスト

```
POST /api/logout
```

#### レスポンス

```json
{
  "success": true,
  "message": "ログアウトしました"
}
```

### 4.4 トラッキングタグ作成

#### リクエスト

```
POST /api/tracking-tags
```

```json
{
  "name": "ホームページCTAボタン",
  "description": "トップページの申し込みボタンのトラッキング"
}
```

#### レスポンス

```json
{
  "success": true,
  "data": {
    "id": 123,
    "tenant_id": 5,
    "name": "ホームページCTAボタン",
    "tag_key": "a1b2c3d4-e5f6-7890-abcd-ef1234567890",
    "description": "トップページの申し込みボタンのトラッキング",
    "is_active": true,
    "created_at": "2023-03-15T10:30:00Z",
    "updated_at": "2023-03-15T10:30:00Z"
  }
}
```

### 4.5 トラッキングイベント記録

#### リクエスト

```
POST /api/tracking-events
```

```json
{
  "tag_key": "a1b2c3d4-e5f6-7890-abcd-ef1234567890",
  "event_type": "click",
  "page_url": "https://example.com/",
  "element_id": "cta-button",
  "element_class": "btn btn-primary",
  "event_data": {
    "button_text": "今すぐ申し込む",
    "position": "header"
  }
}
```

#### レスポンス

```json
{
  "success": true,
  "data": {
    "id": 456789,
    "event_id": "evt_a1b2c3d4e5f6"
  }
}
```

### 4.6 AI分析リクエスト

#### リクエスト

```
POST /api/ai/analyze
```

```json
{
  "tag_id": 123,
  "date_range": {
    "start": "2023-03-01",
    "end": "2023-03-15"
  },
  "analysis_type": "conversion_optimization"
}
```