<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        // スーパー管理者
        Tenant::factory()->create([
            'name' => 'システム管理者',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'plan_type' => 'premium',
            'status' => 'active',
        ]);

        // デモテナント
        Tenant::factory()->create([
            'name' => 'デモテナント',
            'email' => 'demo@example.com',
            'password' => Hash::make('password'),
            'role' => 'tenant_admin',
            'plan_type' => 'standard',
            'status' => 'active',
        ]);

        // テスト用テナント
        Tenant::factory(3)
            ->tenantAdmin()
            ->freePlan()
            ->create();

        Tenant::factory(3)
            ->tenantAdmin()
            ->premiumPlan()
            ->create();
    }
} 