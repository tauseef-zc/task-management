<?php

namespace Tests\Feature\Http\Controllers\V1\Api\Tasks\Projects;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

final class CreateProjectControllerTest extends TestCase
{
    use RefreshDatabase;
        
    /**
     * test_it_can_create_project_for_user
     *
     * @return void
     */
    public function test_it_can_create_project_for_user(): void
    {
        $user = $this->makeUser()->create();

        $response = $this->actingAs($user)->postJson(route('tasks.projects.store'), [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
        ]);
        
        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJsonStructure([
                     'data' => [
                         'id',
                         'message'
                     ],
                 ]);
    }

    /**
     * test_it_cannot_create_project_for_user_unauthenticated
     *
     * @return void
     */
    public function test_it_cannot_create_project_for_user_unauthenticated(): void
    {
        $response = $this->postJson(route('tasks.projects.store'), [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
        ]);
        
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
                 ->assertJsonStructure([
                     'message',
                 ]);
    }

    /**
     * test_it_cannot_create_project_for_user_invalid_payload
     *
     * @return void
     */
    public function test_it_cannot_create_project_for_user_invalid_payload(): void
    {
        $user = $this->makeUser()->create();

        $response = $this->actingAs($user)->postJson(route('tasks.projects.store'), [
            'name' => null,
            'description' => null,
        ]);
        
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                 ->assertJsonStructure([
                     'message',
                     'errors' => [
                         'name',
                         'description'
                     ]
                 ]);
    }
}