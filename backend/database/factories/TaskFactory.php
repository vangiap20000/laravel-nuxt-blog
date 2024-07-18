<?php

namespace Database\Factories;

use App\Models\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class TaskFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = TaskStatus::pluck('id');
        $userId = User::first()->id;;

        return [
            'user_id' => $userId,
            'title' => fake()->name(),
            'content' => fake()->text,
            'type' => rand(1, 4),
            'status' => fake()->randomElement($status),
        ];
    }
}
