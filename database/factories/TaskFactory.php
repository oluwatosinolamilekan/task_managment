<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3), // Generate a fake sentence with 3 words
            'description' => $this->faker->paragraph(2), // Generate a fake paragraph with 2 sentences
            'is_completed' => $this->faker->boolean(20), // 20% chance that the task is completed
        ];
    }
}
