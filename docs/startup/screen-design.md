# 画面設計書

本ドキュメントでは、AI-SaaS テンプレートの画面設計について説明します。

## 1. 画面遷移図

### 1.1 スーパーユーザー画面遷移図

```mermaid
graph TD
    Login[ログイン画面] --> Dashboard[スーパーユーザーダッシュボード]
    
    Dashboard --> TenantMgmt[テナント管理]
    
    TenantMgmt --> TenantDetail[テナント詳細]
    TenantDetail --> TenantEdit[テナント編集]
    
    TenantDetail --> TenantTracker[テナントのトラッカー閲覧]
    TenantTracker --> TenantTags[テナントのタグ管理]
    TenantTracker --> TenantAnalytics[テナントのデータ分析]
            
    Dashboard --> Logout[ログアウト]
```

### 1.2 一般ユーザー画面遷移図

```mermaid
graph TD
    Login[ログイン画面] --> Dashboard[ユーザーダッシュボード]
    
    Dashboard --> Tracker[コンバージョントラッカー]
    Dashboard --> UserSettings[ユーザー設定]
    Dashboard --> Help[ヘルプ]
    
    Tracker --> TagManagement[タグ管理]
    TagManagement --> CreateTag[タグ作成]
    TagManagement --> EditTag[タグ編集]
    
    Tracker --> DataAnalysis[データ分析]
    DataAnalysis --> FilterData[データフィルタリング]
    
    UserSettings --> ProfileSettings[プロフィール設定]
    UserSettings --> SecuritySettings[セキュリティ設定]
    
    Dashboard --> Logout[ログアウト]
```


## 2. ユーザーフロー図

### 2.1 スーパーユーザーのユーザーフロー

#### 2.1.1 テナント管理フロー

```mermaid
flowchart LR
    Start([開始]) --> Login[ログイン]
    Login --> Dashboard[ダッシュボード]
    Dashboard --> TenantMgmt[テナント管理]
    TenantMgmt --> NewTenant{新規作成?}
    
    NewTenant -- はい --> CreateTenant[テナント情報入力]
    CreateTenant --> SelectPlan[プラン選択]
    SelectPlan --> SaveTenant[作成完了]
    SaveTenant --> TenantDetail[テナント詳細]
    
    NewTenant -- いいえ --> SelectTenant[テナント選択]
    SelectTenant --> TenantDetail
    
    TenantDetail --> ManageUsers[ユーザー管理]
    TenantDetail --> ViewAnalytics[分析データ閲覧]
    TenantDetail --> EditSettings[設定編集]
    
    ManageUsers --> End([終了])
    ViewAnalytics --> End
    EditSettings --> End
```

#### 2.1.2 システム監視フロー

```mermaid
flowchart LR
    Start([開始]) --> Login[ログイン]
    Login --> Dashboard[ダッシュボード]
    Dashboard --> SystemStatus[システム状態確認]
    SystemStatus --> Anomaly{異常検知?}
    
    Anomaly -- はい --> CheckLogs[詳細ログ確認]
    CheckLogs --> TakeAction[対応措置実施]
    TakeAction --> VerifyFix[修正確認]
    VerifyFix --> End([終了])
    
    Anomaly -- いいえ --> RoutineCheck[定期チェック]
    RoutineCheck --> End
```

### 2.2 一般ユーザーのユーザーフロー

#### 2.2.1 トラッキングタグ設置フロー

```mermaid
flowchart LR
    Start([開始]) --> Login[ログイン]
    Login --> Dashboard[ダッシュボード]
    Dashboard --> Tracker[コンバージョントラッカー]
    Tracker --> TagMgmt[タグ管理]
    TagMgmt --> GenerateTag[タグ生成]
    GenerateTag --> CopyCode[タグコードコピー]
    CopyCode --> InstallTag[自社サイトにタグ設置]
    InstallTag --> VerifyTag[動作確認]
    VerifyTag --> End([終了])
```

#### 2.2.2 データ分析フロー

```mermaid
flowchart LR
    Start([開始]) --> Login[ログイン]
    Login --> Dashboard[ダッシュボード]
    Dashboard --> Tracker[コンバージョントラッカー]
    Tracker --> DataAnalysis[データ分析]
    DataAnalysis --> SetPeriod[期間設定]
    SetPeriod --> ViewData[データ確認]
    ViewData --> ViewGraphs[グラフ表示]
    ViewGraphs --> Filter{フィルタリング?}
    
    Filter -- はい --> ApplyFilter[フィルター適用]
    ApplyFilter --> ViewGraphs
    
    Filter -- いいえ --> End([終了])
```

#### 2.2.3 CTA最適化フロー（AI提案機能付き）

```mermaid
flowchart LR
    Start([開始]) --> DataAnalysis[データ分析]
    DataAnalysis --> IdentifyLowCTA[低パフォーマンスCTA特定]
    IdentifyLowCTA --> AIAnalysis[AI分析実行]
    AIAnalysis --> AIRecommendation[AI改善提案表示]
    AIRecommendation --> ModifyCTA[自社サイトでCTA修正]
    ModifyCTA --> MeasureEffect[効果測定]
    MeasureEffect --> CheckImprovement{改善確認?}
    
    CheckImprovement -- はい --> Document[改善内容記録]
    Document --> End([終了])
    
    CheckImprovement -- いいえ --> AIAnalysis
```

## 3. アクセス権限表

| 画面/機能 | スーパーユーザー | 一般ユーザー |
|------------|-----------------|------------|
| ダッシュボード | ✅ | ✅ |
| テナント管理 | ✅ | ❌ |
| テナント詳細 | ✅ | ❌ |
| ユーザー管理（全体） | ✅ | ❌ |
| テナント内ユーザー管理 | ✅ | ❌ |
| システム設定 | ✅ | ❌ |
| コンバージョントラッカー | ✅（全テナント閲覧可） | ✅（自テナントのみ） |
| タグ管理 | ✅（全テナント閲覧可） | ✅（自テナントのみ） |
| データ分析 | ✅（全テナント閲覧可） | ✅（自テナントのみ） |
| AI改善提案 | ✅（全テナント閲覧可） | ✅（自テナントのみ） |
| 自分のプロフィール | ✅ | ✅ |
| ヘルプ/ドキュメント | ✅ | ✅ |

## 4. 画面レイアウト概要

以下に主要画面のレイアウト概要を示します。実際の開発では、これらの概要を元にしたデザインカンプやUIコンポーネントを作成します。

### 4.1 共通レイアウト
- **ヘッダー**: ロゴ、サイト名、ユーザーメニュードロップダウン
- **サイドバー**: 主要ナビゲーションメニュー（階層構造）
- **メインコンテンツエリア**: 各画面の主要コンテンツを表示
- **フッター**: コピーライト情報、リンク等

### 4.2 ダッシュボード画面
- ウェルカムメッセージ
- KPIカード（テナント数、ユーザー数、CTR等）
- アクティビティグラフ（時系列データ）
- 最近のアクティビティリスト

### 4.3 テナント管理画面
- アクションボタン（新規テナント作成等）
- 検索フィルター
- テナント一覧テーブル（ソート・フィルタ機能付き）
- ページネーション

### 4.4 コンバージョントラッカー
- **タグ管理**:
  - トラッキングタグコード表示（コピー機能付き）
  - 設置手順ガイド
  - 新規タグ作成機能

- **データ分析**:
  - 期間選択フィルター
  - データグラフ（クリックレート推移、CTA要素別クリック率等）
  - AI改善提案セクション

### 4.5 AI改善提案画面
- 分析対象CTA要素の選択
- 現在のパフォーマンス指標表示
- AI分析結果と改善提案リスト
- 改善案プレビュー
- 実装ガイダンス