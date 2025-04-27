<?php

namespace Tests\Feature\Http\Controllers\V1\Api\Tasks;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

final class SingleTaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_it_can_get_task
     *
     * @return void
     */
    public function test_it_can_get_task(): void
    {
        $user = $this->makeUser()->create();
        $task = $this->makeTask()->createdBy($user)->create();

        $response = $this->actingAs($user)
            ->getJson(route('tasks.single', $task->id));

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'created_by',
                    'assigned_to',
                    'project',
                    'priority',
                    'due_date',
                    'spent_time',
                    'estimated_time',
                    'attachments',
                    'status',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    /**
     * test_it_can_not_get_task_if_task_does_not_exist
     *
     * @return void
     */
    public function test_it_can_not_get_task_if_task_does_not_exist(): void
    {
        $user = $this->makeUser()->create();

        $response = $this->actingAs($user)
            ->getJson(route('tasks.single', 999));

        $response->assertNotFound()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * test_it_can_not_get_task_if_user_is_not_authenticated
     *
     * @return void
     */
    public function test_it_can_not_get_task_if_user_is_not_authenticated(): void
    {
        $task = $this->makeTask()->create();

        $response = $this->getJson(route('tasks.single', $task->id));

        $response->assertUnauthorized()
            ->assertJsonStructure([
                'message',
            ]);
    }
}