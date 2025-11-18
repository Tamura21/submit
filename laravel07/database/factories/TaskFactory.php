<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;
use App\Models\User;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'task_status' => $this->faker->numberBetween(0, 2),
            'comment' => $this->faker->optional()->text(200),
            // Create a new user for each task by default. Tests can override user_id.
            'user_id' => User::factory(),
        ];
    }
}