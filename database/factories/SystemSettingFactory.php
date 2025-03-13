<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SystemSetting>
 */
class SystemSettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => $this->faker->unique()->word(),
            'value' => $this->faker->randomElement([
                $this->faker->numberBetween(1, 100),
                $this->faker->boolean(),
                $this->faker->sentence(),
                ['key' => 'value'],
            ]),
            'description' => $this->faker->sentence(),
            'is_tenant_configurable' => $this->faker->boolean(),
        ];
    }
}
