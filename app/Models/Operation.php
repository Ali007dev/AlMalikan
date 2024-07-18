<?php

namespace App\Models;

use App\Enums\FileStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function image()
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', FileStatusEnum::OTHER);
    }
}
