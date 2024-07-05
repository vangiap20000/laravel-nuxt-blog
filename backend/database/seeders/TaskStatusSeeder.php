<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('const.task_status') as $key => $status) {
            TaskStatus::create([
                'name' => $status
            ]);
        }
    }
}
