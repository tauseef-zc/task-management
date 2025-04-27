<?php

namespace Tests\Feature\Http\Controllers\V1\Api\Tasks\Comments;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class GetTaskCommentControllerTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * test_it_can_get_task_comment
     *
     * @return void
     */
    public function test_it_can_get_task_comment(): void
    {
        $user = $this->makeUser()->create();
        $task = $this->makeTask()->createdBy($user)->create();
        $comment = $this->makeTaskComment(2)->createdBy($user)->forTask($task)->create();

        $response = $this->actingAs($user)
            ->getJson(route('tasks.comments', $task->id));

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'comment',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);

        $this->assertCount(2, $response->json('data'));
        $this->assertEquals($comment[0]->id, $response->json('data.0.id'));
    }

    /**
     * test_it_can_not_get_task_comment_if_task_does_not_exist
     *
     * @return void
     */
    public function test_it_can_not_get_task_comment_if_task_does_not_exist(): void
    {
        $user = $this->makeUser()->create();

        $response = $this->actingAs($user)
            ->getJson(route('tasks.comments', 999));

        $response->assertNotFound()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * test_it_can_not_get_task_comment_if_user_is_not_authenticated
     *
     * @return void
     */
    public function test_it_can_not_get_task_comment_if_user_is_not_authenticated(): void
    {
        $task = $this->makeTask()->create();

        $response = $this->getJson(route('tasks.comments', $task->id));

        $response->assertUnauthorized()
            ->assertJsonStructure([
                'message',
            ]);
    }
}