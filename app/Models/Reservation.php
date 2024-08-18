<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['day'];

    public function getDayAttribute() {
        $originalLocale = Carbon::getLocale();

        Carbon::setLocale('ar');

        $day = Carbon::parse($this->date)->isoFormat('dddd');

        Carbon::setLocale($originalLocale);

        return $day;
    }
    protected $with=['customer:id,first_name,last_name','employee:id,first_name,last_name','branch:id,name','service:id,name,price'];
    public function customer()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class,'employee_id');
    }

    public function service()
    {
        return $this->belongsTo(Operation::class,'operation_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class,'branch_id');
    }


}
