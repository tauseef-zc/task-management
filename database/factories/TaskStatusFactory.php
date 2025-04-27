<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskStatus>
 */
class TaskStatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'color' => $this->faker->hexColor(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
    
    /**
     * Indicate that the model's created_by should be unique.
     *
     * @return static
     */
    public function user(?User $user = null): static
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'created_by' => $user ? $user->id : User::factory()->create()->id,
            ];
        });
    }
    
}
