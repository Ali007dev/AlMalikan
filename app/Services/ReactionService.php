<?php

namespace App\Services;

use App\Models\ImageDescription;
use Illuminate\Support\Facades\Auth;

class ReactionService
{
    public function react($image)
    {
        $reaction = ImageDescription::where('id', $image->id)->first();
        $reaction->reactions()->create(
            [
                'user_id' => Auth::user()->id,
            ]
        );
        return true;
    }
}
