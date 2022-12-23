<?php

namespace Database\Factories;

use App\Models\User;
use App\Services\PortfolioProviders\Enums\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccessToken>
 */
class AccessTokenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'provider' => Provider::DeviantArt->value,
            'access_token' => $this->faker->unique()->text(199),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+1 hour')),
            'refresh_token' => $this->faker->unique()->text(199),
        ];
    }
}
