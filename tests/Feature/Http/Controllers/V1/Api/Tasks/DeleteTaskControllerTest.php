<?php

namespace Tests\Feature\Http\Controllers\V1\Api\Tasks;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

final class DeleteTaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_it_can_delete_task
     *
     * @return void
     */
    public function test_it_can_delete_task(): void
    {
        $user = $this->makeUser()->create();
        $task = $this->makeTask()->createdBy($user)->create();

        $response = $this->actingAs($user)
            ->deleteJson(route('tasks.delete', $task->id));

        $response->assertSuccessful()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * test_it_can_not_delete_task_if_task_does_not_exist
     *
     * @return void
     */
    public function test_it_can_not_delete_task_if_task_does_not_exist(): void
    {
        $user = $this->makeUser()->create();

        $response = $this->actingAs($user)
            ->deleteJson(route('tasks.delete', 999));

        $response->assertNotFound()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * test_it_can_not_delete_task_if_user_is_not_authenticated
     *
     * @return void
     */
    public function test_it_can_not_delete_task_if_user_is_not_authenticated(): void
    {
        $task = $this->makeTask()->create();

        $response = $this->deleteJson(route('tasks.delete', $task->id));

        $response->assertUnauthorized()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * test_it_can_not_delete_task_if_user_is_not_authorized
     *
     * @return void
     */
    public function test_it_can_not_delete_task_if_user_is_not_authorized(): void
    {
        $user = $this->makeUser()->create();
        $task = $this->makeTask()->createdBy($this->makeUser()->create())->create();

        $response = $this->actingAs($user)
            ->deleteJson(route('tasks.delete', $task->id));

        $response->assertForbidden()
            ->assertJsonStructure([
                'message',
            ]);
    }
}