<?php

namespace Database\Factories;

use App\Enums\RoleEnum;
use App\Models\Employee;
use App\Models\Experince;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Experince>
 */
class ExperinceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $employees = Employee::all();

        return [
            'employee_id' => $employees->random()->id,
            'description' => $this->faker->sentence,
            'name' => $this->faker->name,
        ];
    }
}
