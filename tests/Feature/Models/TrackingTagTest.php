<?php

namespace Tests\Feature\Models;

use App\Models\Tenant;
use App\Models\TrackingTag;
use App\Models\TrackingEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackingTagTest extends TestCase
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
     * トラッキングタグの作成テスト
     */
    public function test_can_create_tracking_tag(): void
    {
        $tenant = Tenant::factory()->create();
        $tag = TrackingTag::factory()->create([
            'tenant_id' => $tenant->id,
            'name' => 'テストタグ',
            'description' => 'テスト用のタグ',
        ]);

        $this->assertDatabaseHas('tracking_tags', [
            'name' => 'テストタグ',
            'description' => 'テスト用のタグ',
            'tenant_id' => $tenant->id,
        ]);
    }

    /**
     * テナントとのリレーションテスト
     */
    public function test_belongs_to_tenant(): void
    {
        $tenant = Tenant::factory()->create();
        $tag = TrackingTag::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $this->assertInstanceOf(Tenant::class, $tag->tenant);
        $this->assertEquals($tenant->id, $tag->tenant->id);
    }

    /**
     * トラッキングイベントとのリレーションテスト
     */
    public function test_has_many_tracking_events(): void
    {
        $tag = TrackingTag::factory()->create();
        $events = TrackingEvent::factory()->count(3)->create([
            'tag_id' => $tag->id,
        ]);

        $this->assertCount(3, $tag->trackingEvents);
        $this->assertInstanceOf(TrackingEvent::class, $tag->trackingEvents->first());
        $this->assertEquals($tag->id, $tag->trackingEvents->first()->tag_id);
    }
}
