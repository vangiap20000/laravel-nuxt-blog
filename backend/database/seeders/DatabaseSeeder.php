<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TaskStatus;
use App\Models\Task;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $this->call(TaskStatusSeeder::class);

        $statusIds = TaskStatus::pluck('id');
        foreach ($statusIds as $key => $statusId) {
            Task::factory()->create([
                'title' => fake()->name(),
                'content' => fake()->text,
                'type' => rand(1, 4),
                'status' => $statusId
            ]);
        }

        Task::factory(10)->create();
    }
}
