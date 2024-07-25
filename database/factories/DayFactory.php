<?php

namespace Database\Factories;

use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Day>
 */
class DayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = '01-02-2024';
        $branches = Branch::all();
        for($i=0;$i<100;$i++){
            if(Carbon::parse($date)->format('l') != 'Friday'){
                $date = Carbon::parse($date)->addDay()->format('Y-m-d');
                return [
                    'branch_id' => $branches->random()->id,
                    'date' => $date,
                ];
            }
        }

    }
}
