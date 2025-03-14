<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackingEventResource extends JsonResource
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
            'tag_id' => $this->tag_id,
            'event_type' => $this->event_type,
            'page_url' => $this->page_url,
            'element_id' => $this->element_id,
            'element_class' => $this->element_class,
            'user_agent' => $this->user_agent,
            'properties' => $this->properties,
            'client_ip' => $this->client_ip,
            'event_time' => $this->event_time->toIso8601String(),
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
            // リレーション
            'tenant' => new TenantResource($this->whenLoaded('tenant')),
            'tracking_tag' => new TrackingTagResource($this->whenLoaded('trackingTag')),
        ];
    }
} 