<?php

namespace Tests\Feature\Models;

use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserSettingTest extends TestCase
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
     * ユーザー設定の作成テスト
     */
    public function test_can_create_user_setting(): void
    {
        $user = User::factory()->create();
        $setting = UserSetting::factory()->create([
            'user_id' => $user->id,
            'theme' => 'dark',
            'notification_preferences' => [
                'email' => true,
                'push' => false,
            ],
        ]);

        $this->assertDatabaseHas('user_settings', [
            'user_id' => $user->id,
            'theme' => 'dark',
        ]);

        $this->assertEquals([
            'email' => true,
            'push' => false,
        ], $setting->notification_preferences);
    }

    /**
     * ユーザーとのリレーションテスト
     */
    public function test_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $setting = UserSetting::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $setting->user);
        $this->assertEquals($user->id, $setting->user->id);
    }

    /**
     * JSON型のキャストテスト
     */
    public function test_notification_preferences_are_casted_to_array(): void
    {
        $setting = UserSetting::factory()->create([
            'notification_preferences' => [
                'email' => true,
                'push' => false,
            ],
        ]);

        $this->assertIsArray($setting->notification_preferences);
        $this->assertArrayHasKey('email', $setting->notification_preferences);
        $this->assertArrayHasKey('push', $setting->notification_preferences);
    }
}
