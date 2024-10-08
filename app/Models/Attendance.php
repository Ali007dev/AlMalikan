<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = ['day','status'];

    public function getDayAttribute() {
        $originalLocale = Carbon::getLocale();

        Carbon::setLocale('ar');

        $day = Carbon::parse($this->date)->isoFormat('dddd');

        Carbon::setLocale($originalLocale);

        return $day;
    }

    public function getStatusAttribute(){
        $branch = Branch::where('id',$this->branch_id)->first();
        if($branch){
            if ($branch -> start_time < $this->checkIn){
                return 'late';
            }
            else return 'attended';
        }
        return Carbon::parse($this->date)->format('l');
    }
    protected $hidden = ['created_at','updated_at'];
}
