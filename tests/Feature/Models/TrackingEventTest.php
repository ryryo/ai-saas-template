<?php

namespace Tests\Feature\Models;

use App\Models\User;
use App\Models\Tenant;
use App\Models\TrackingTag;
use App\Models\TrackingEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackingEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * トラッキングイベントの作成テスト
     */
    public function test_can_create_tracking_event(): void
    {
        $tenant = Tenant::factory()->create();
        $tag = TrackingTag::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $event = TrackingEvent::factory()->create([
            'tenant_id' => $tenant->id,
            'tag_id' => $tag->id,
            'event_type' => 'page_view',
            'properties' => [
                'page' => '/home',
                'referrer' => 'https://example.com',
            ],
        ]);

        $this->assertDatabaseHas('tracking_events', [
            'tenant_id' => $tenant->id,
            'tag_id' => $tag->id,
            'event_type' => 'page_view',
        ]);
    }

    /**
     * テナントとのリレーションテスト
     */
    public function test_belongs_to_tenant(): void
    {
        $tenant = Tenant::factory()->create();
        $event = TrackingEvent::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $this->assertInstanceOf(Tenant::class, $event->tenant);
        $this->assertEquals($tenant->id, $event->tenant->id);
    }

    /**
     * トラッキングタグとのリレーションテスト
     */
    public function test_belongs_to_tracking_tag(): void
    {
        $tag = TrackingTag::factory()->create();
        $event = TrackingEvent::factory()->create([
            'tag_id' => $tag->id,
        ]);

        $this->assertInstanceOf(TrackingTag::class, $event->tag);
        $this->assertEquals($tag->id, $event->tag->id);
    }

    /**
     * プロパティのJSON型キャストテスト
     */
    public function test_properties_are_casted_to_array(): void
    {
        $event = TrackingEvent::factory()->create([
            'properties' => [
                'page' => '/home',
                'referrer' => 'https://example.com',
            ],
        ]);

        $this->assertIsArray($event->properties);
        $this->assertEquals('/home', $event->properties['page']);
        $this->assertEquals('https://example.com', $event->properties['referrer']);
    }
}
