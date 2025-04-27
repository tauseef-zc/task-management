<?php

namespace Tests\Feature\Http\Controllers\V1\Api\Tasks\Statuses;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class DeleteTaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_it_can_delete_task_status
     *
     * @return void
     */
    public function test_it_can_delete_task_status(): void
    {
        $user = $this->makeUser()->create();
        $taskStatus = $this->makeTaskStatus()->create([
            'created_by' => $user->id
        ]);

        $response = $this->actingAs($user)->deleteJson(route('tasks.statuses.delete', $taskStatus));
        $response->assertAccepted();
        $response->assertJsonStructure([
            'message'
        ]);
        $this->assertDatabaseMissing('task_statuses', [
            'id' => $taskStatus->id,
            'created_by' => $user->id
        ]);
    }

    /**
     * test_it_cannot_delete_task_status_for_invalid_task_status
     *
     * @return void
     */
    public function test_it_cannot_delete_task_status_for_invalid_task_status(): void
    {
        $user = $this->makeUser()->create();
        $taskStatus = $this->makeTaskStatus()->create([
            'created_by' => $user->id
        ]);

        $response = $this->actingAs($user)->deleteJson(route('tasks.statuses.delete', $taskStatus->id + 1));
        $response->assertNotFound();
    }

    /**
     * test_it_cannot_delete_task_status_unauthenticated
     *
     * @return void
     */
    public function test_it_cannot_delete_task_status_unauthenticated(): void
    {
        $taskStatus = $this->makeTaskStatus()->create();
        $response = $this->deleteJson(route('tasks.statuses.delete', $taskStatus));
        $response->assertUnauthorized();
    }
    
}