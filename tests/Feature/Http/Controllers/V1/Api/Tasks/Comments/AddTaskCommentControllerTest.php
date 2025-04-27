<?php

namespace Tests\Feature\Http\Controllers\V1\Api\Tasks\Comments;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class AddTaskCommentControllerTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * test_it_can_add_task_comment
     *
     * @return void
     */
    public function test_it_can_add_task_comment(): void
    {
        $user = $this->makeUser()->create();
        $task = $this->makeTask()->createdBy($user)->create();

        $response = $this->actingAs($user)
            ->postJson(route('tasks.comments.store', $task->id),
                ['comment' => 'This is a test comment']
            );

        $response->assertSuccessful()             
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'message',
                    ],
                ]);
    }

    /**
     * test_it_can_not_add_task_comment_if_task_does_not_exist
     *
     * @return void
     */
    public function test_it_can_not_add_task_comment_if_task_does_not_exist(): void
    {
        $user = $this->makeUser()->create();

        $response = $this->actingAs($user)
            ->postJson(route('tasks.comments.store', 999),
                ['comment' => 'This is a test comment']
            );

        $response->assertNotFound()
                ->assertJsonStructure([
                    'message',
                ]);
    }

    /**
     * test_it_can_not_add_task_comment_if_user_is_not_authenticated
     *
     * @return void
     */
    public function test_it_can_not_add_task_comment_if_user_is_not_authenticated(): void
    {
        $task = $this->makeTask()->create();

        $response = $this->postJson(route('tasks.comments.store', $task->id),
            ['comment' => 'This is a test comment']
        );

        $response->assertUnauthorized()
                ->assertJsonStructure([
                    'message',
                ]);
    }

    /**
     * test_it_can_not_add_task_comment_if_comment_is_empty
     *
     * @return void
     */
    public function test_it_can_not_add_task_comment_if_comment_is_empty(): void
    {
        $user = $this->makeUser()->create();
        $task = $this->makeTask()->createdBy($user)->create();

        $response = $this->actingAs($user)
            ->postJson(route('tasks.comments.store', $task->id),
                ['comment' => '']
            );

        $response->assertUnprocessable()
                ->assertJsonStructure([
                    'message',
                    'errors' => [
                        'comment'
                    ],
                ]);
    }
}