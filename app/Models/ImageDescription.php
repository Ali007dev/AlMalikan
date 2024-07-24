<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageDescription extends Model
{
    use HasFactory;

    public function description()
    {
        return $this->hasMany(ImageDescription::class,'before_id');
    }
}
