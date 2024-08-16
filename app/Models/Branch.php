<?php

namespace App\Models;

use App\Services\FilterService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;
    protected $with = ['image'];

    protected $guarded = [];

    protected $fiillable = ['id'];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_branches', 'branch_id');
    }

    public function client()
    {
        return $this->hasMany(User::class)->where('role', 'user');
    }

    public function services()
    {
        return $this->hasMany(Operation::class);
    }

    public function employee()
    {
        return $this->hasMany(User::class)->where('role', 'employee');
    }

    public function absence()
    {
        $result = $this->hasMany(Absence::class);
        return$result ;
    }
    public function attendance()
    {
       
        $result = $this->hasMany(Attendance::class);
        return  $result;
    }
    public function late()
    {
        $date = request()->query('date');
        $result = $this->hasMany(Late::class);
        return app(FilterService::class)->filterDate($result, $date, 'date');
    }

    public function getBranchTime($id)
    {
        $branch = Branch::find($id);

        if ($branch) {
            return [
                $branch->start_time,
                $branch->end_time
            ];
        } else {
            return null;
        }
    }
}
