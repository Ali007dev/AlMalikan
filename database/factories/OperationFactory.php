<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Operation>
 */
class OperationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_time = $this->faker->time('H:i');
        $end_time = $this->faker->time('H:i');


        return [
            'name'=> $this->faker->name,
            'from' => $start_time,
            'to' => $end_time,
            'price' => $this->faker->randomFloat(2,0,0),
        ];
    }
}
