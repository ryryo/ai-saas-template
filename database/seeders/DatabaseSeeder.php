<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // スーパー管理者テナント
        Tenant::create([
            'name' => 'スーパー管理者',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'plan_type' => 'premium',
            'status' => 'active',
        ]);

        // デモテナント
        Tenant::create([
            'name' => 'デモテナント',
            'email' => 'demo@example.com',
            'password' => Hash::make('password'),
            'role' => 'tenant_admin',
            'plan_type' => 'free',
            'status' => 'active',
        ]);
    }
}
