<?php

namespace App\Services;

use App\Enums\FileStatusEnum;
use App\Models\Branch;

class BranchService
{

    public  function index()
    {
        return  Branch::get()->toArray();
    }

    public  function show($branch_id)
    {
        return  Branch::findOrFail($branch_id);
    }

    public  function store($request)
    {
    $data = $request->except('image');
    $branch = Branch::create($data);

    if ($request->hasFile('image')){
      $image = upload($request->image, 'branches/images');
      $branch->image()->create([
        'image'=>$image,
        'type'=> FileStatusEnum::OTHER
    ]);
}
    return  $branch;


    }

    public function update($branch_id, $request)
    {
        return  Branch::findOrFail($branch_id)->update([
            "name" => $request->name
        ]);

    }

    public function destroy($branch_id)
    {
        Branch::findOrFail($branch_id)->delete();
        return true;
    }
}