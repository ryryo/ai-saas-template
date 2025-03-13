<?php

namespace Database\Factories;

use App\Models\Tenant;
use App\Models\TrackingTag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrackingTag>
 */
class TrackingTagFactory extends Factory
{
    protected $model = TrackingTag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
            'color' => $this->faker->hexColor(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
