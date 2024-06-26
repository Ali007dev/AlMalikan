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
        'phone_number'=> '0992992992',
        'password'=>Hash::make('password'),

       ]);

      // Experince::createRandom();
    }

}
