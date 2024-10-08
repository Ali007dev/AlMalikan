<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    use Searchable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public function queueMakeSearchable()
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'phone_number' => $this->phone_number,
        ];
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id');
    }

    public function profileImage()
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', 'profile');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->where('type', '!=', 'profile');
    }

    public function late()
    {
        return $this->hasMany(Late::class, 'employee_id');
    }

    public function allAttendance()
    {
        return $this->hasMany(Attendance::class);
    }
    public function absence()
    {
        return $this->hasMany(Absence::class, 'user_id');
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'user_branches', 'user_id');
    }

    public function services()
    {
        return $this->belongsToMany(Operation::class, 'employee_services', 'user_id');
    }
    public function attendance()
    {
        return $this->hasOne(Attendance::class)
            ->where('date', Carbon::now()->format('Y-m-d'));
    }

    public function customerReservation()
    {
        return $this->hasMany(Reservation::class, 'user_id');
    }

    public function employeeReservation()
    {
        return $this->hasMany(Reservation::class, 'employee_id');
    }

    public function recentCustomerReservation()
    {
        return $this->hasMany(Reservation::class, 'user_id')->whereDate('date', '>=', Carbon::today());
    }
    public function archiveCustomerReservation()
    {
        return $this->hasMany(Reservation::class, 'user_id')->whereDate('date', '<', Carbon::today())->where('status','!=','waiting');
    }
}
