<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function experince()
    {
        return $this->hasMany(Experince::class);
    }
    public function salary()
    {
        return $this->hasMany(Salary::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
