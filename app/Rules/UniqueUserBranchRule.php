<?php

namespace App\Rules;

use App\Models\User;
use App\Models\UserBranch;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueUserBranchRule implements ValidationRule
{

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

    //     $branches = request()->input('branches');
    //     $existingBranch = UserBranch::whereIn('branch_id', $branches)
    //         ->where('user_id', ؟؟ )->get();
    //         foreach($existingBranch as $exist){

    //         }

    //     if ($existingBranch) {

    //         throwError(transMsg('unique_error'));
    //     }

    // }
}
}
