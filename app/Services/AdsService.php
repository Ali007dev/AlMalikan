<?php

namespace App\Services;

use App\Enums\FileStatusEnum;
use App\Models\Ad;

class AdsService
{

    public  function index()
    {
        return  Ad::get()->toArray();
    }

    public  function show($branch_id)
    {
        return  Ad::findOrFail($branch_id);
    }

    public  function store($request)
    {
        $data = $request->except('image');
        $ad = Ad::create($data);
        if ($request->hasFile('image')) {
            $image = upload($request->image, 'offer/images');
            $ad->image()->create([
                'image' => $image,
                'type' => FileStatusEnum::OTHER
            ]);
        }
        return  $ad;
    }

    public function update($branch_id, $request)
    {
        $data = $request->except('image');
       $ad = Ad::findOrFail($branch_id);
       $ad->update($data);
       if($request->image){
        $image = upload($request->image, 'offer/images');
        $ad->image()->update(
            [
                'image' =>$image,
                'type' => FileStatusEnum::OTHER

            ]
        );

        return  $ad;
       }
    }

    public function destroy($branch_id)
    {
        Ad::findOrFail($branch_id)->delete();
        return true;
    }
}
