<?php

namespace Tests\Feature\Http\Controllers\V1\Api\Tasks\Projects;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class DeleteProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_it_can_delete_project_for_user
     *
     * @return void
     */
    public function test_it_can_delete_project_for_user(): void
    {
        $user = $this->makeUser()->create();
        $project = $this->makeProject()->user($user)->create();

        $response = $this->actingAs($user)->deleteJson(route('tasks.projects.delete', ['project' => $project]));

        $response->assertSuccessful()
                 ->assertJsonStructure([
                     'message',
                 ]);

        $this->assertDatabaseMissing('projects', [
            'id' => $project->id,
        ]);
    }

    /**
     * test_it_cannot_delete_project_for_user_unauthenticated
     *
     * @return void
     */
    public function test_it_cannot_delete_project_for_user_unauthenticated(): void
    {
        $project = $this->makeProject()->user()->create();

        $response = $this->deleteJson(route('tasks.projects.delete', ['project' => $project]));

        $response->assertUnauthorized()
                 ->assertJsonStructure([
                     'message',
                 ]);
    }
}