<?php

namespace Tests\Feature\Http\Controllers\V1\Api\Tasks\Projects;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class GetProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_it_can_get_project_for_user
     *
     * @return void
     */
    public function test_it_can_get_project_for_user(): void
    {
        $user = $this->makeUser()->create();
        $this->makeProject(10)->user($user)->create();

        $response = $this->actingAs($user)->getJson(route('tasks.projects.index'));

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
        $this->assertCount(10, $response->json('data'));
    }

    /**
     * test_it_cannot_get_project_for_user_unauthenticated
     *
     * @return void
     */
    public function test_it_cannot_get_project_for_user_unauthenticated(): void
    {
        $this->makeProject(10)->user()->create();

        $response = $this->getJson(route('tasks.projects.index'));

        $response->assertUnauthorized()
            ->assertJsonStructure([
                'message',
            ]);
    }

}