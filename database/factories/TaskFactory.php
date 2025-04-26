<?php

namespace Database\Factories;

use App\Enums\TaskPriorityEnum;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'created_by' => $user->id,
        ]);

        return [
            //
            'name' => $this->faker->sentence(3),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->paragraph(3),
            'created_by' => $user->id,
            'project_id' => $project->id,
            'parent_id' => null,
            'status_id' => $this->faker->numberBetween(1, 3),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'priority' => $this->faker->randomElement(TaskPriorityEnum::getValues()),
            'progress' => $this->faker->numberBetween(0, 100),
            'estimated_time' => $this->faker->numberBetween(1, 10),
            'spent_time' => $this->faker->numberBetween(1, 10),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }

    
    /**
     * Indicate that the task is created by a specific user.
     *
     * @param  User $user
     * @return static
     */
    public function createdBy(?User $user = null): static
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'created_by' => $user ? $user->id : User::factory()->create()->id,
            ];
        });
    }
    
    /**
     * Indicate that the task is assigned to a project.
     *
     * @param  Project $project
     * @return static
     */
    public function project(?Project $project = null): static
    {
        return $this->state(function (array $attributes) use ($project) {
            return [
                'project_id' => $project ? $project->id : Project::factory()->create()->id,
            ];
        });
    }
    
}
