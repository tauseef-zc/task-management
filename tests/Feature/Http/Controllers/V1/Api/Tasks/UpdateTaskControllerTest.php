<?php

namespace Tests\Feature\Http\Controllers\V1\Api\Tasks;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

final class UpdateTaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_it_can_update_task
     *
     * @return void
     */
    public function test_it_can_update_task(): void
    {
        $user = $this->makeUser()->create();
        $task = $this->makeTask()->createdBy($user)->create();

        $response = $this->actingAs($user)
            ->putJson(route('tasks.update', $task->id), [
                'name' => 'Updated Task Name',
                'description' => 'Updated Task Description',
            ]);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'message',
                ]
            ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => 'Updated Task Name',
            'description' => 'Updated Task Description',
        ]);
    }

    /**
     * test_it_can_not_update_task_if_task_does_not_exist
     *
     * @return void
     */
    public function test_it_can_not_update_task_if_task_does_not_exist(): void
    {
        $user = $this->makeUser()->create();

        $response = $this->actingAs($user)
            ->putJson(route('tasks.update', 999), [
                'name' => 'Updated Task Name',
                'description' => 'Updated Task Description',
            ]);

        $response->assertNotFound()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * test_it_can_not_update_task_if_user_is_not_authenticated
     *
     * @return void
     */
    public function test_it_can_not_update_task_if_user_is_not_authenticated(): void
    {
        $task = $this->makeTask()->create();

        $response = $this->putJson(route('tasks.update', $task->id), [
            'name' => 'Updated Task Name',
            'description' => 'Updated Task Description',
        ]);

        $response->assertUnauthorized()
            ->assertJsonStructure([
                'message',
            ]);
    }
}