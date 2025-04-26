<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'test@test.com')->first();

        TaskStatus::insert([
            [
                'name' => 'Pending',
                'slug' => 'pending',
                'color' => '#ff0000',
                'created_by' => $user->id,
            ],
            [
                'name' => 'In Progress',
                'slug' => 'in-progress',
                'color' => '#ffff00',
                'created_by' => $user->id,
            ],
            [
                'name' => 'Completed',
                'slug' => 'completed',
                'color' => '#00ff00',
                'created_by' => $user->id,
            ],
        ]);
    }
}
