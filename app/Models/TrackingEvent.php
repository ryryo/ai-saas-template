<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrackingEvent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tenant_id',
        'tag_id',
        'event_type',
        'page_url',
        'element_id',
        'element_class',
        'user_agent',
        'properties',
        'client_ip',
        'event_time',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_agent' => 'array',
        'properties' => 'array',
        'event_time' => 'datetime',
    ];

    /**
     * Get the tenant that owns the tracking event.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the tracking tag that owns the tracking event.
     */
    public function tag(): BelongsTo
    {
        return $this->belongsTo(TrackingTag::class, 'tag_id');
    }
}
