<?php

namespace Tests\Feature\Http\Controllers\V1\Api\Tasks\Statuses;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class GetTaskStatusControllerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * test_it_cannot_get_task_statuses_unauthenticated
     *
     * @return void
     */
    public function test_it_cannot_get_task_statuses_unauthenticated(): void
    {
        $response = $this->getJson(route('tasks.statuses.index'));
        $response->assertUnauthorized();
    }
    
    /**
     * test_it_should_get_task_statuses_empty
     *
     * @return void
     */
    public function test_it_should_get_task_statuses_empty(): void
    {
        $user = $this->makeUser()->create();
        $response = $this->actingAs($user)->getJson(route('tasks.statuses.index'));
        
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [],
        ]);
        $response->assertJsonCount(0, 'data');
    }

    /**
     * test_it_can_get_task_statuses
     *
     * @return void
     */
    public function test_it_can_get_task_statuses(): void
    {
        $user = $this->makeUser()->create();
        $this->makeTaskStatus(5)->create([
            'created_by' => $user->id,
        ]);

        $response = $this->actingAs($user)->getJson(route('tasks.statuses.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'color',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

}