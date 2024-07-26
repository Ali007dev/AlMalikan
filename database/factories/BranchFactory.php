<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branch>
 */
class BranchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

             'name' => $this->faker->name,
             'location' => $this->faker->name,
             'start_time' => '09:00:00',
             'end_time' => '05:00:00',
             'description' => $this->faker->title,
             'working_days' => json_encode(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday']),

         ];
    }
}
