<?php

namespace Tests\Feature\Http\Controllers\V1\Api\Tasks\Statuses;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class UpdateTaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_it_can_update_task_status
     *
     * @return void
     */
    public function test_it_can_update_task_status(): void
    {
        $user = $this->makeUser()->create();
        $taskStatus = $this->makeTaskStatus()->user($user)->create();

        $payload = [
            'name' => $this->faker->word,
            'color' => $this->faker->hexColor,
        ];

        $response = $this->actingAs($user)->putJson(route('tasks.statuses.update', $taskStatus), $payload);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'message'
            ],
        ]);
        $this->assertDatabaseHas('task_statuses', [
            'id' => $taskStatus->id,
            'name' => $payload['name'],
            'color' => $payload['color'],        
            'created_by' => $user->id
        ]);
    }

    /**
     * test_it_cannot_update_task_status_for_invalid_task_status
     *
     * @return void
     */
    public function test_it_cannot_update_task_status_for_invalid_task_status(): void
    {
        $user = $this->makeUser()->create();
        $taskStatus = $this->makeTaskStatus()->user($user)->create();

        $payload = [
            'name' => $this->faker->word,
            'color' => $this->faker->hexColor,
        ];

        $response = $this->actingAs($user)->putJson(route('tasks.statuses.update', $taskStatus->id + 1), $payload);
        $response->assertNotFound();
        
    }

    /**
     * test_it_cannot_update_task_status_unauthenticated
     *
     * @return void
     */
    public function test_it_cannot_update_task_status_unauthenticated(): void
    {
        $taskStatus = $this->makeTaskStatus()->create();
        $response = $this->putJson(route('tasks.statuses.update', $taskStatus));
        $response->assertUnauthorized();
    }
}