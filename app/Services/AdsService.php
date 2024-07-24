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
            $image = upload($request->image, 'branches/images');
            $ad->image()->create([
                'image' => $image,
                'type' => FileStatusEnum::OTHER
            ]);
        }
        return  $ad;
    }

    public function update($branch_id, $request)
    {
        return  Ad::findOrFail($branch_id)->update($request->all());
    }

    public function destroy($branch_id)
    {
        Ad::findOrFail($branch_id)->delete();
        return true;
    }
}
