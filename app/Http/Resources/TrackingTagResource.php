<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackingTagResource extends JsonResource
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
            'tenant_id' => $this->tenant_id,
            'name' => $this->name,
            'tag_key' => $this->tag_key,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
            // リレーション
            'tenant' => new TenantResource($this->whenLoaded('tenant')),
            'tracking_events_count' => $this->when(
                isset($this->tracking_events_count),
                fn () => $this->tracking_events_count
            ),
        ];
    }
} 