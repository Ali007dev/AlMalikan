<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeService;
use App\Models\Operation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = Operation::get();

        $employees = User::where('role', 'employee')->get();
        foreach ($employees as $employee) {
            Employee::create([
                'user_id' => $employee->id,
                'description' => 'aaaaaaa',
                'pin' => '1',
                'start_date' => '2024-06-26',
                'salary' => '11111',
                'position'=>fake()->randomElement(['hr', 'doctor','clinic officer']),
                'national_id' => '01111111111',
                'ratio' => 20,
            ]);
            EmployeeService::create([
                'operation_id' => $services->random()->id,
                'user_id' => $employee->id,
            ]);
    }
}
}
