<?php

namespace Tests\Feature\Http\Controllers\V1\Api\Tasks;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

final class GetTaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_it_can_get_tasks
     *
     * @return void
     */
    public function test_it_can_get_tasks(): void
    {
        $user = $this->makeUser()->create();
        $this->makeTask(5)->createdBy($user)->create();

        $response = $this->actingAs($user)
            ->getJson(route('tasks.index'));

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
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
                ],
            ]);
    }

    /**
     * test_it_can_not_get_tasks_if_user_is_not_authenticated
     *
     * @return void
     */
    public function test_it_can_not_get_tasks_if_user_is_not_authenticated(): void
    {
        $response = $this->getJson(route('tasks.index'));

        $response->assertUnauthorized()
            ->assertJsonStructure([
                'message',
            ]);
    }

}