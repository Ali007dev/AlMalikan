<?php

namespace App\Services;

use App\Enums\FileStatusEnum;
use App\Enums\RoleEnum;
use App\Models\ImageDescription;
use App\Models\User;

class UserService
{
    public function index()
    {
        return User::where('role', RoleEnum::USER)->with('profileImage')->get()->toArray();
    }

    public function storeImages($user, $request)
    {
        $user = User::findOrFail($user);

        $descriptions = [];

        foreach ($request->images as $image) {
            $imagePath = upload($image['image'], 'user/images');
            $storedTmage = $user->images()->create([
                'image' => $imagePath,
                'type' => $image['type'],
            ]);
            $temp = $this->checkFileType($image['type'], FileStatusEnum::AFTER, $storedTmage);
            if ($temp) $after = $temp;
            $temp = $this->checkFileType($image['type'], FileStatusEnum::BEFORE, $storedTmage);
            if ($temp) $before = $temp;
        }
        $descriptions[] = [
            'before_id' => $before,
            'after_id' => $after,
            'description' => $request->description,
        ];
        ImageDescription::insert($descriptions);
    }


    private function checkFileType($var1, $var2, $var3)
    {

        if ($var1 === $var2) {
            return $var3->id;
        }
    }
}
