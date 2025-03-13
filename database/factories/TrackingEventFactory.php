<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Tenant;
use App\Models\TrackingTag;
use App\Models\TrackingEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrackingEvent>
 */
class TrackingEventFactory extends Factory
{
    protected $model = TrackingEvent::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'tag_id' => TrackingTag::factory(),
            'event_type' => $this->faker->randomElement(['page_view', 'click', 'form_submit', 'api_call']),
            'properties' => [
                'page' => $this->faker->url(),
                'referrer' => $this->faker->url(),
                'user_agent' => $this->faker->userAgent(),
                'ip_address' => $this->faker->ipv4(),
            ],
        ];
    }
}
