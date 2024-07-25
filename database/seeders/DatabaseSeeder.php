<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Absence;
use App\Models\Ad;
use App\Models\Attendance;
use App\Models\Branch;
use App\Models\Complaint;
use App\Models\Day;
use App\Models\Employee;
use App\Models\Experince;
use App\Models\Late;
use App\Models\Operation;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Branch::factory(5)->create();

        $this->call(UserSeeder::class);
      User::factory(10)->create();
      Employee::factory(10)->create();
      Experince::factory(10)->create();
      Complaint::factory(50)->create();
      Late::factory(30)->create();
      Attendance::factory(500)->create();
       Operation::factory(20)->create();
       Absence::factory(20)->create();
<<<<<<< HEAD
       Day::factory(20)->create();
=======
       Ad::factory(20)->create();
>>>>>>> 6abc61a16ce4ed3a4f3b88cbf8175e37b46bd61b

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
