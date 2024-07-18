<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TaskStatus;
use App\Models\Task;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create();
        $this->call(TaskStatusSeeder::class);

        $statusIds = TaskStatus::pluck('id');
        $userId = User::first()->id;
        foreach ($statusIds as $key => $statusId) {
            Task::create([
                'user_id' => $userId,
                'title' => fake()->name(),
                'content' => fake()->text,
                'type' => rand(1, 4),
                'status' => $statusId,
            ]);
        }

        Task::factory(10)->create();
    }
}
