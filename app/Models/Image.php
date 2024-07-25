<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $hidden = ['created_at','updated_at'];

protected $guarded=[];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function description()
    {
        return $this->hasMany(ImageDescription::class,'before_id');
    }
}
