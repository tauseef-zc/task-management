<?php

namespace Tests\Feature\Http\Controllers\V1\Api\Tasks\Projects;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class SingleProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_it_can_get_single_project_for_user
     *
     * @return void
     */
    public function test_it_can_get_single_project_for_user(): void
    {
        $user = $this->makeUser()->create();
        $project = $this->makeProject()->user($user)->create();

        $response = $this->actingAs($user)->getJson(route('tasks.projects.single', ['project' => $project]));

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'created_at',
                    'updated_at',
                ],
            ]);

        $this->assertEquals($project->id, $response->json('data.id'));
    }

    /**
     * test_it_cannot_get_single_project_for_user_unauthenticated
     *
     * @return void
     */
    public function test_it_cannot_get_single_project_for_user_unauthenticated(): void
    {
        $project = $this->makeProject()->user()->create();
        $response = $this->getJson(route('tasks.projects.single', ['project' => $project]));

        $response->assertUnauthorized()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * test_it_cannot_get_single_project_for_user_not_found
     *
     * @return void
     */
    public function test_it_cannot_get_single_project_for_user_not_found(): void
    {
        $user = $this->makeUser()->create();
        $response = $this->actingAs($user)->getJson(route('tasks.projects.single', ['project' => 0]));

        $response->assertNotFound()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * test_it_cannot_get_single_project_for_user_invalid_project
     *
     * @return void
     */
    public function test_it_cannot_get_single_project_for_user_invalid_project(): void
    {
        $user = $this->makeUser()->create();
        $project = $this->makeProject()->user($user)->create();

        $response = $this->actingAs($user)->getJson(route('tasks.projects.single', ['project' => $project->id + 1]));

        $response->assertNotFound()
            ->assertJsonStructure([
                'message',
            ]);
    }
}