<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Experince extends Model
{
    use HasFactory;

    use Searchable;

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

    protected $fillable = [
        'employee_id',
        'description',
        'name',
    ];
    public static function createRandom()
    {
        return self::create([
           'employee_id' =>Experince::factory()->create()->id,
            'description' => 'This is a random factory with description: ' . mt_rand(1, 100),
            'name' => 'Random Factory ' . mt_rand(1, 1000),
        ]);
    }
}
