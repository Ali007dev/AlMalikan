<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageDescription extends Model
{
    use HasFactory;
    protected $hidden = ['created_at','updated_at'];

    protected $with =['before','after'];
    public function before()
    {
        return $this->belongsTo(Image::class,'before_id');
    }

    public function after()
    {
        return $this->belongsTo(Image::class,'after_id');
    }


}
