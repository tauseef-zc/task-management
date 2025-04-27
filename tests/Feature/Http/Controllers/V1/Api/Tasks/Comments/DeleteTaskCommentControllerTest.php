<?php

namespace Tests\Feature\Http\Controllers\V1\Api\Tasks\Comments;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class DeleteTaskCommentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_it_can_delete_task_comment
     *
     * @return void
     */
    public function test_it_can_delete_task_comment(): void
    {
        $user = $this->makeUser()->create();
        $task = $this->makeTask()->createdBy($user)->create();
        $comment = $this->makeTaskComment()->createdBy($user)->forTask($task)->create();

        $response = $this->actingAs($user)
            ->deleteJson(route('tasks.comments.delete', [$task->id, $comment->id]));

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'message',
                ],
            ]);
    }

    /**
     * test_it_can_not_delete_task_comment_if_task_does_not_exist
     *
     * @return void
     */
    public function test_it_can_not_delete_task_comment_if_task_does_not_exist(): void
    {
        $user = $this->makeUser()->create();
        $comment = $this->makeTaskComment()->createdBy($user)->create();

        $response = $this->actingAs($user)
            ->deleteJson(route('tasks.comments.delete', [999, $comment->id]));

        $response->assertNotFound()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * test_it_can_not_delete_task_comment_if_user_is_not_authenticated
     *
     * @return void
     */
    public function test_it_can_not_delete_task_comment_if_user_is_not_authenticated(): void
    {
        $task = $this->makeTask()->create();
        $comment = $this->makeTaskComment()->forTask($task)->create();

        $response = $this->deleteJson(route('tasks.comments.delete', [$task->id, $comment->id]));

        $response->assertUnauthorized()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * test_it_can_not_delete_task_comment_if_user_is_not_authorized
     *
     * @return void
     */
    public function test_it_can_not_delete_task_comment_if_user_is_not_authorized(): void
    {
        $user = $this->makeUser()->create();
        $task = $this->makeTask()->createdBy($user)->create();
        $comment = $this->makeTaskComment()
            ->createdBy($this->makeUser()->create())
            ->forTask($task)
            ->create();

        $response = $this->actingAs($user)
            ->deleteJson(route('tasks.comments.delete', [$task->id, $comment->id]));

        $response->assertForbidden()
            ->assertJsonStructure([
                'error',
            ]);
    }

    /**
     * test_it_can_not_delete_task_comment_if_comment_does_not_belong_to_task
     *
     * @return void
     */
    public function test_it_can_not_delete_task_comment_if_comment_does_not_belong_to_task(): void
    {
        $user = $this->makeUser()->create();
        $task = $this->makeTask()->createdBy($user)->create();
        $comment = $this->makeTaskComment()
            ->createdBy($user)
            ->forTask($this->makeTask()->create())
            ->create();

        $response = $this->actingAs($user)
            ->deleteJson(route('tasks.comments.delete', [$task->id, $comment->id]));

        $response->assertNotFound()
            ->assertJsonStructure([
                'error',
            ]);
    }

}