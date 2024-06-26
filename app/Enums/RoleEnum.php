<?php

namespace App\Enums;

use Illuminate\Support\Facades\Enum;
use Illuminate\Validation\Rules\Enum as RulesEnum;

class RoleEnum extends RulesEnum
{
    public const ADMIN = 'admin';
    public const EMPLOYEE = 'employee';
    public const USER = 'user';
}
