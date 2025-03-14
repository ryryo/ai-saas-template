<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TenantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'domain' => $this->domain,
            'plan_type' => $this->plan_type,
            'status' => $this->status,
            'last_login_at' => $this->last_login_at?->toIso8601String(),
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
            // 認証済みテナントまたはスーパー管理者の場合のみ設定を含める
            'settings' => $this->when(
                $request->user()?->id === $this->id || $request->user()?->role === 'super_admin',
                fn () => $this->settings
            ),
        ];
    }
} 