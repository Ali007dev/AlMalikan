<?php

namespace App\Rules;

use App\Models\ImageDescription;
use App\Models\Reaction;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class UniqueReactionRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $image = request()->input('id');
        $existingReaction = Reaction::where('likable_id', $image)
            ->where('likable_type', ImageDescription::class)
            ->where('user_id', Auth::user()->id)
            ->first();

        if ($existingReaction) {

            throwError(transMsg('unique_error'));
        }
    }
}
