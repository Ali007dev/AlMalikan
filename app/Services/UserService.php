<?php

namespace App\Services;

use App\Enums\FileStatusEnum;
use App\Enums\RoleEnum;
use App\Models\ImageDescription;
use App\Models\User;
use App\Models\UserBranch;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function index($id)
    {
        return User::where('role', RoleEnum::USER)
            ->where('branch_id', $id)->with('profileImage', 'branches:id,name')
            ->get()->toArray();
    }

    public function show($user)
    {
        $result = User::where('role', RoleEnum::USER)
            ->with('profileImage')
            ->findOrFail($user);
        return $result;
    }

    public function me()
    {
        $result = User::where('role', RoleEnum::USER)
            ->with('profileImage')
            ->findOrFail(Auth::user()->id);
        return $result;
    }

    public function storeImages($user, $request)
    {
        $user = User::findOrFail($user);

        $descriptions = [];

        foreach ($request->images as $image) {
            $imagePath = upload($image['image'], 'user/images');

            $storedImage  = $user->images()->create([
                'image' => $imagePath,
                'type' => $image['type'],
            ]);
            $imageResponse[] = [
                'image' => $imagePath,
                'type' => $image['type'],
            ];
            $temp = $this->checkFileType($image['type'], FileStatusEnum::AFTER, $storedImage);
            if ($temp) $after = $temp;
            $temp = $this->checkFileType($image['type'], FileStatusEnum::BEFORE, $storedImage);
            if ($temp) $before = $temp;
        }
        $descriptions[] = [
            'before_id' => $before,
            'after_id' => $after,
            'description' => $request->description,
        ];
        ImageDescription::insert($descriptions);

        return $imageResponse;
    }
    private function checkFileType($var1, $var2, $var3)
    {
        if ($var1 === $var2) {
            return $var3->id;
        }
    }

    public function getBeforeAfterImages()
    {
        return ImageDescription::withCount('reactions')->paginate(10);
    }


    public function deleteBeforeAfterImages($id)
    {
        return ImageDescription::findOrFail($id)->delete();
    }

    public function getBeforeAfterImageswithoutPaginate()
    {
        return ImageDescription::withCount('reactions')->get()->toArray();
    }

    public function addBranchesForUser($branches, $user)
    {

        $data = [];
        foreach ($branches as $branch) {
            $data[] = [
                'branch_id' => $branch,
                'user_id' => $user,
            ];
        }
        UserBranch::insert(array_unique($data, SORT_REGULAR));
        return true;
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return true;
    }


    public function update($request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only([
            'first_name',
            'last_name',
            'middle_name',
            'phone_number',
            'email',
            'password',
            'role',
            'branch_id',
        ]));

        if ($request->image) {
            $image = upload($request->image, 'user/images');
            $user->image()->delete();
            $user->image()->create(
                [
                    'image' => $image,
                    'type' => FileStatusEnum::PROFILE
                ]
            );
        }

        return $user;
    }
}
