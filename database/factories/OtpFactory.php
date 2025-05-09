<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Otp>
 */
class OtpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'otp' => random_int(100000, 999999),
            'expires_at' => now()->addMinutes(60),
            'verified' => false,
            'taggable_id' => random_int(1, 100),
            'taggable_type' => User::class,
        ];
    }

    /**
     * verified
     *
     * @return static
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'verified' => true,
        ]);
    }

    /**
     * expired
     *
     * @return static
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'expires_at' => now()->subMinutes(60),
        ]);
    }
}
