<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = ['day'];

    public function getDayAttribute(){
        return Carbon::parse($this->date)->format('l');
    }
    protected $hidden = ['created_at','updated_at'];
}
