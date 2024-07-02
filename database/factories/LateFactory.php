<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Late>
 */
class LateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $employees = Employee::all();
        $branch = Branch::all();


        return [
           'employee_id' => $employees->random()->id,
            'branch_id' => $branch->random()->id,
            'date' => $this->faker->dateTime('now'),
            'hours' => $this->faker->numberBetween(1,4),
        ];
    }
}
