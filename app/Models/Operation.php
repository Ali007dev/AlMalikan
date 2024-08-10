<?php

namespace App\Models;

use App\Enums\FileStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;
    protected $guarded=[];

    protected $appends = ['newPrice'];

    public function getNewPriceAttribute(){
        $now = Carbon::now()->format('Y-m-d');

        $discount = ServiceDiscount::where('operation_id',$this->id)
        ->where('from','<=', $now)
        ->where('to','>=', $now)->sum('value');
        if( $discount){
        $discountPercentage = ($this->price * $discount) / 100;
        return $this->price - $discountPercentage;
        }
        else return 0;

    }
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', FileStatusEnum::OTHER);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'employee_services', 'operation_id');
    }

    public function employees()
    {
        return $this->belongsToMany(User::class, 'employee_services', 'operation_id')->where('role','employee');
    }
}
