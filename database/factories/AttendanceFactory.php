<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $employees = Employee::all();
        $branches = Branch::all();

        return [
            'user_id' => $employees->random()->id,
            'branch_id' => $branches->random()->id,

            'date' => $this->faker->dateTimeBetween('01-05-2024','01-08-2024'),
            'checkIn' => $this->faker->time('01:01:11'),
            'checkOut' => $this->faker->time('09:01:11'),
        ];
    }
}
