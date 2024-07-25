<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branch>
 */
class ComplaintFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::all();
        $branches = Branch::all();

        return [

             'content' => $this->faker->sentence(10),
             'date' => $this->faker->dateTimeBetween('2020-01-01'),
             'user_id' => $user->random()->id,
             'branch_id' => $branches->random()->id,


         ];
    }
}
