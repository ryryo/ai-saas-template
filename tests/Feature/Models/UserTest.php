<?php

namespace Tests\Feature\Models;

use App\Models\User;
use App\Models\Tenant;
use App\Models\UserSetting;
use App\Models\TrackingEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
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
     * ユーザーの作成テスト
     */
    public function test_can_create_user(): void
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'tenant_id' => $tenant->id,
        ]);
    }

    /**
     * ユーザーのソフトデリートテスト
     */
    public function test_can_soft_delete_user(): void
    {
        $user = User::factory()->create();
        $user->delete();

        $this->assertSoftDeleted($user);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'deleted_at' => now(),
        ]);
    }

    /**
     * テナントとのリレーションテスト
     */
    public function test_belongs_to_tenant(): void
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $this->assertInstanceOf(Tenant::class, $user->tenant);
        $this->assertEquals($tenant->id, $user->tenant->id);
    }

    /**
     * ユーザー設定とのリレーションテスト
     */
    public function test_has_one_user_setting(): void
    {
        $user = User::factory()->create();
        $setting = UserSetting::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(UserSetting::class, $user->setting);
        $this->assertEquals($user->id, $user->setting->user_id);
    }

    /**
     * トラッキングイベントとのリレーションテスト
     */
    public function test_has_many_tracking_events(): void
    {
        $user = User::factory()->create();
        $events = TrackingEvent::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        $this->assertCount(3, $user->trackingEvents);
        $this->assertInstanceOf(TrackingEvent::class, $user->trackingEvents->first());
        $this->assertEquals($user->id, $user->trackingEvents->first()->user_id);
    }
}
