<?php

namespace Tests\Feature\Models;

use App\Models\SystemSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SystemSettingTest extends TestCase
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
     * システム設定の作成テスト
     */
    public function test_can_create_system_setting(): void
    {
        $setting = SystemSetting::factory()->create([
            'key' => 'site_name',
            'value' => ['en' => 'My Site', 'ja' => 'マイサイト'],
            'description' => 'サイト名の設定',
            'is_tenant_configurable' => true,
        ]);

        $this->assertDatabaseHas('system_settings', [
            'key' => 'site_name',
            'description' => 'サイト名の設定',
            'is_tenant_configurable' => true,
        ]);

        $this->assertEquals([
            'en' => 'My Site',
            'ja' => 'マイサイト',
        ], $setting->value);
    }

    /**
     * 設定値の取得テスト
     */
    public function test_can_get_setting_value(): void
    {
        SystemSetting::factory()->create([
            'key' => 'max_users',
            'value' => 100,
        ]);

        $value = SystemSetting::getValue('max_users');
        $this->assertEquals(100, $value);

        $defaultValue = SystemSetting::getValue('non_existent_key', 50);
        $this->assertEquals(50, $defaultValue);
    }

    /**
     * 設定値の更新テスト
     */
    public function test_can_set_setting_value(): void
    {
        $setting = SystemSetting::setValue(
            'maintenance_mode',
            true,
            'メンテナンスモードの設定',
            false
        );

        $this->assertDatabaseHas('system_settings', [
            'key' => 'maintenance_mode',
            'value' => true,
            'description' => 'メンテナンスモードの設定',
            'is_tenant_configurable' => false,
        ]);

        // 既存の設定の更新
        $updatedSetting = SystemSetting::setValue(
            'maintenance_mode',
            false,
            'メンテナンスモードの設定（更新）',
            true
        );

        $this->assertDatabaseHas('system_settings', [
            'key' => 'maintenance_mode',
            'value' => false,
            'description' => 'メンテナンスモードの設定（更新）',
            'is_tenant_configurable' => true,
        ]);
    }

    /**
     * JSON型のキャストテスト
     */
    public function test_value_is_casted_to_array(): void
    {
        $setting = SystemSetting::factory()->create([
            'value' => ['key' => 'value'],
        ]);

        $this->assertIsArray($setting->value);
        $this->assertArrayHasKey('key', $setting->value);
    }
}
