<?php

namespace App\Services;

use App\Enums\RoleEnum;
use App\Models\User;

class UserService
{
public function index(){

    return User::where('role',RoleEnum::USER)->with('profileImage')->get()->toArray();
}

}
