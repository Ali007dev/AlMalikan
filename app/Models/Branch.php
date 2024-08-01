<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory,SoftDeletes;
    protected $with = ['image'];

    protected $guarded =[];


    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'user_branches','branch_id');
    }

    public function client()
    {
        return $this->hasMany(User::class)->where('role','user');
    }

    public function employee()
    {
        return $this->hasMany(User::class)->where('role','employee');
    }
}
