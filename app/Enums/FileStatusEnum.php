<?php

namespace App\Enums;

use Illuminate\Support\Facades\Enum;
use Illuminate\Validation\Rules\Enum as RulesEnum;

class FileStatusEnum extends RulesEnum
{
    public const OTHER = 'other';
    public const PROFILE = 'profile';
    public const BEFORE = 'before';
    public const AFTER = 'after';

}
