<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'name' => $this->faker->company(),
            'domain' => $this->faker->unique()->domainName(),
            'plan_type' => $this->faker->randomElement(['free', 'basic', 'pro']),
            'status' => $this->faker->randomElement(['active', 'inactive', 'suspended']),
            'settings' => [
                'max_users' => $this->faker->numberBetween(1, 100),
                'max_storage' => $this->faker->numberBetween(100, 1000),
                'features' => $this->faker->randomElements(['analytics', 'api', 'custom_domain'], 2),
            ],
        ];
    }
}
