<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskComment>
 */
class TaskCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        $task = Task::factory()->createdBy($user)->create();

        return [
            'task_id' => $task->id,
            'user_id' => $user->id,
            'comment' => $this->faker->paragraph(1),
            'reply_to' => null,
        ];
    }

    /**
     * Indicate that the comment is a reply to another comment.
     *
     * @param  TaskComment|null  $comment
     * @return static
     */
    public function replyTo(?TaskComment $comment = null): static
    {
        return $this->state(function (array $attributes) use ($comment) {
            return [
                'reply_to' => $comment ? $comment->id : TaskComment::factory()->create()->id,
            ];
        });
    }

    /**
     * Indicate that the comment is created by a specific user.
     *
     * @param  User|null  $user
     * @return static
     */
    public function createdBy(?User $user = null): static
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'user_id' => $user ? $user->id : User::factory()->create()->id,
            ];
        });
    }

    /**
     * Indicate that the comment is created for a specific task.
     *
     * @param  Task|null  $task
     * @return static
     */
    public function forTask(?Task $task = null): static
    {
        return $this->state(function (array $attributes) use ($task) {
            return [
                'task_id' => $task ? $task->id : Task::factory()->create()->id,
            ];
        });
    }
}
