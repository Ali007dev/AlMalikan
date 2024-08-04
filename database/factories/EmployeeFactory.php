<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $employees = User::where('role','employee')->get();

        return [
            'user_id' => $employees->random()->id,
            'description' => $this->faker->sentence,
            'pin' => '1',
            'start_date' => '2024-06-26',
            'salary' => '11111',
            'national_id' => '01111111111',
            'ratio' => 20,

        ];
    }
}
