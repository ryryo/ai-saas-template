<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tenant>
 */
class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'tenant_admin',
            'plan_type' => 'standard',
            'status' => 'active',
            'domain' => null,
            'settings' => [],
            'last_login_at' => null,
        ];
    }

    /**
     * スーパー管理者として設定
     */
    public function superAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'super_admin',
        ]);
    }

    /**
     * テナント管理者として設定
     */
    public function tenantAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'tenant_admin',
        ]);
    }

    /**
     * 無料プランとして設定
     */
    public function freePlan(): static
    {
        return $this->state(fn (array $attributes) => [
            'plan_type' => 'free',
        ]);
    }

    /**
     * プレミアムプランとして設定
     */
    public function premiumPlan(): static
    {
        return $this->state(fn (array $attributes) => [
            'plan_type' => 'premium',
        ]);
    }
}
