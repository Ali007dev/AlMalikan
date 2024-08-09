<?php

namespace Database\Seeders;

use App\Models\Experince;
use App\Models\User;
use Carbon\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void


    {





       User::create([
        'first_name'=> 'admin',
        'last_name'=> 'admin',
        'middle_name'=> 'admin',
        'role'=> 'admin',

        'phone_number'=> '0992992992',
        'email'=> 'admin@admin.com',
        'password'=>Hash::make('password'),
        'branch_id' => 1,

       ]);
       User::create([
        'first_name'=> 'admin',
        'role'=> 'admin',
        'middle_name'=> 'admin',
        'phone_number'=> '0992992991',
        'last_name'=> 'admin',
        'email'=> 'admin@gmail.com',
        'password'=>Hash::make('password'),
        'branch_id' => 1,

       ]);

      // Experince::createRandom();
    }

}
