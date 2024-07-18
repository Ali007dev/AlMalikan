<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum ;

class RoleEnum extends Enum
{
    public const ADMIN = 'admin';
    public const EMPLOYEE = 'employee';
    public const USER = 'user';
}
