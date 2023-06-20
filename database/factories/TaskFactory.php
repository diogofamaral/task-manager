<?php

namespace Database\Factories;

use App\Enum\TaskPriority;
use App\Enum\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array
    {
        return [
            'name' => fake()->words(rand(2, 5), true),
            'description' => fake()->text(175),
            'status' => TaskStatus::PENDING,
            'priority' => fake()->randomElement(TaskPriority::values()),
            'deadline_at' => fake()->date(),
        ];
    }
}
