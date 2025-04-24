<?php

namespace Tests\Feature\Http\Controllers\V1\Api\Tasks\Statuses;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CreateTaskStatusControllerTest extends TestCase
{    
    use RefreshDatabase;
    
    /**
     * test_it_can_create_task_status
     *
     * @return void
     */
    public function test_it_can_create_task_status(): void
    {
        $user = $this->makeUser()->create();
        $payload = [
            'name' => $this->faker->word,
            'color' => $this->faker->hexColor,
        ];

        $response = $this->actingAs($user)->postJson(route('tasks.statuses.create'), $payload);
        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'message'
            ],
        ]);
    }    

    /**
     * test_it_cannot_create_task_status_invalid_payload
     *
     * @return void
     */
    public function test_it_cannot_create_task_status_invalid_payload(): void
    {
        $user = $this->makeUser()->create();
        $payload = [];

        $response = $this->actingAs($user)->postJson(route('tasks.statuses.create'), $payload);
        $response->assertUnprocessable();
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name'
            ]
        ]);
    }
    
    /**
     * test_it_cannot_create_task_status_unauthenticated
     *
     * @return void
     */
    public function test_it_cannot_create_task_status_unauthenticated(): void
    {
        $response = $this->postJson(route('tasks.statuses.create'));
        $response->assertUnauthorized();
    }
}