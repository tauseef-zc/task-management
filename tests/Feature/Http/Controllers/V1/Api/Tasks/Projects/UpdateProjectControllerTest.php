<?php

namespace Tests\Feature\Http\Controllers\V1\Api\Tasks\Projects;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_it_can_update_project_for_user
     *
     * @return void
     */
    public function test_it_can_update_project_for_user(): void
    {
        $user = $this->makeUser()->create();
        $project = $this->makeProject()->user($user)->create();

        $this->actingAs($user)->putJson(route('tasks.projects.update', ['project' => $project]), [
            'name' => 'Updated Project Name',
            'description' => 'Updated Project Description',
        ])->assertOk()
          ->assertJsonStructure([
              'data' => [
                  'id',
                  'message'
              ],
          ]);

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => 'Updated Project Name',
            'description' => 'Updated Project Description',
        ]);
    }

    /**
     * test_it_cannot_update_project_for_user_unauthenticated
     *
     * @return void
     */
    public function test_it_cannot_update_project_for_user_unauthenticated(): void
    {
        $project = $this->makeProject()->user()->create();

        $this->putJson(route('tasks.projects.update', ['project' => $project]), [
            'name' => 'Updated Project Name',
            'description' => 'Updated Project Description',
        ])->assertUnauthorized()
          ->assertJsonStructure([
              'message',
          ]);
    }
}