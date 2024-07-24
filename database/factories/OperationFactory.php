<?php

namespace Database\Factories;

use Carbon\Carbon;
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
        $period =$this->faker->numberBetween(30,120);
        $start_time = $this->faker->time('H:i:00');
        $end_time = Carbon::parse($start_time)->addHours(9) ;

    return [
            'name'=> $this->faker->name,
            'from' => $this->faker->time('H:i:00'),
            'to' => $end_time,
            'price' => $this->faker->randomFloat(1000,10,0),
            'period'=>$period
    ];
    }
}
