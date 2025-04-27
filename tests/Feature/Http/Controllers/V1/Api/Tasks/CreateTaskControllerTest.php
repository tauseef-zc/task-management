<?php

namespace Tests\Feature\Http\Controllers\V1\Api\Tasks;

use App\Enums\TaskPriorityEnum;
use App\Models\TaskStatus;
use Database\Seeders\TaskStatusSeeder;
use Database\Seeders\UserSeeder;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

final class CreateTaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->seed(TaskStatusSeeder::class);
    }

    /**
     * test_it_can_create_task
     *
     * @return void
     */
    public function test_it_can_create_task(): void
    {
        $user = $this->makeUser()->create();
        $project = $this->makeProject()->user($user)->create();

        $response = $this->actingAs($user)
            ->postJson(route('tasks.store'), [
                'name' => 'Test Task',
                'description' => 'This is a test task',
                'status_id' => TaskStatus::first()->id,
                'priority' => TaskPriorityEnum::HIGH->value,
                'due_date' => now()->addDays(7)->format('Y-m-d'),
                'project_id' => $project->id,
            ]);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'message',
                ],
            ]);
    }

    /**
     * test_it_can_not_create_task_if_user_is_not_authenticated
     *
     * @return void
     */
    public function test_it_can_not_create_task_if_user_is_not_authenticated(): void
    {
        $response = $this->postJson(route('tasks.store'));
        $response->assertUnauthorized()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * test_it_can_not_create_task_if_project_does_not_exist
     *
     * @return void
     */
    public function test_it_can_not_create_task_if_project_does_not_exist(): void
    {
        $user = $this->makeUser()->create();

        $response = $this->actingAs($user)
            ->postJson(route('tasks.store'), [
                'name' => 'Test Task',
                'description' => 'This is a test task',
                'status_id' => TaskStatus::first()->id,
                'priority' => TaskPriorityEnum::HIGH->value,
                'due_date' => now()->addDays(7)->format('Y-m-d'),
                'project_id' => 999,
            ]);

        $response->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'project_id',
                ],
            ]);
    }

    /**
     * test_it_can_not_create_task_if_status_does_not_exist
     *
     * @return void
     */
    public function test_it_can_not_create_task_if_status_does_not_exist(): void
    {
        $user = $this->makeUser()->create();
        $project = $this->makeProject()->user($user)->create();

        $response = $this->actingAs($user)
            ->postJson(route('tasks.store'), [
                'name' => 'Test Task',
                'description' => 'This is a test task',
                'status_id' => 999,
                'priority' => TaskPriorityEnum::HIGH->value,
                'due_date' => now()->addDays(7)->format('Y-m-d'),
                'project_id' => $project->id,
            ]);

        $response->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'status_id',
                ],
            ]);
    }
}