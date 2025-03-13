<?php

namespace Tests\Feature\Models;

use App\Models\Tenant;
use App\Models\User;
use App\Models\TrackingTag;
use App\Models\TrackingEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantTest extends TestCase
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
     * テナントの作成テスト
     */
    public function test_can_create_tenant(): void
    {
        $tenant = Tenant::factory()->create([
            'name' => 'テストテナント',
            'domain' => 'test.example.com',
            'plan_type' => 'basic',
        ]);

        $this->assertDatabaseHas('tenants', [
            'name' => 'テストテナント',
            'domain' => 'test.example.com',
            'plan_type' => 'basic',
        ]);
    }

    /**
     * テナントのソフトデリートテスト
     */
    public function test_can_soft_delete_tenant(): void
    {
        $tenant = Tenant::factory()->create();
        $tenant->delete();

        $this->assertSoftDeleted($tenant);
        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'deleted_at' => now(),
        ]);
    }

    /**
     * ユーザーとのリレーションテスト
     */
    public function test_has_many_users(): void
    {
        $tenant = Tenant::factory()->create();
        $users = User::factory()->count(3)->create([
            'tenant_id' => $tenant->id,
        ]);

        $this->assertCount(3, $tenant->users);
        $this->assertInstanceOf(User::class, $tenant->users->first());
        $this->assertEquals($tenant->id, $tenant->users->first()->tenant_id);
    }

    /**
     * トラッキングタグとのリレーションテスト
     */
    public function test_has_many_tracking_tags(): void
    {
        $tenant = Tenant::factory()->create();
        $tags = TrackingTag::factory()->count(3)->create([
            'tenant_id' => $tenant->id,
        ]);

        $this->assertCount(3, $tenant->trackingTags);
        $this->assertInstanceOf(TrackingTag::class, $tenant->trackingTags->first());
        $this->assertEquals($tenant->id, $tenant->trackingTags->first()->tenant_id);
    }

    /**
     * トラッキングイベントとのリレーションテスト
     */
    public function test_has_many_tracking_events(): void
    {
        $tenant = Tenant::factory()->create();
        $tag = TrackingTag::factory()->create([
            'tenant_id' => $tenant->id,
        ]);
        $events = TrackingEvent::factory()->count(3)->create([
            'tenant_id' => $tenant->id,
            'tag_id' => $tag->id,
        ]);

        $this->assertCount(3, $tenant->trackingEvents);
        $this->assertInstanceOf(TrackingEvent::class, $tenant->trackingEvents->first());
        $this->assertEquals($tenant->id, $tenant->trackingEvents->first()->tenant_id);
    }
}
