<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Complaint extends Model
{
    use HasFactory;
    use Searchable;

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'content' => $this->content,
        ];
    }

    protected $with = ['user:id,first_name,last_name'];
    protected $guarded=[];
    protected $appends = ['day'];

    public function getDayAttribute(){
        return Carbon::parse($this->date)->format('l');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    protected $hidden=['created_at','updated_at'];

}
