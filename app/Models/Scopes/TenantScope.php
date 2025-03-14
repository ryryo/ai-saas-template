<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class TenantScope implements Scope
{
    /**
     * すべてのクエリにテナントスコープを適用
     */
    public function apply(Builder $builder, Model $model)
    {
        if (Auth::check() && !app()->runningInConsole()) {
            $tenant = Auth::user();
            
            // スーパー管理者の場合はスコープを適用しない
            if ($tenant->isSuperAdmin()) {
                return;
            }
            
            // テナント自身のテーブルの場合はスコープを適用しない
            if ($model->getTable() === 'tenants') {
                $builder->where('id', $tenant->id);
            } else {
                $builder->where($model->getTable() . '.tenant_id', $tenant->id);
            }
        }
    }
} 