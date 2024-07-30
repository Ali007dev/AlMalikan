<?php

namespace App\Services;

use App\Enums\FileStatusEnum;
use App\Models\Branch;
use App\Models\Operation;

class OperationService
{

    public  function index($branch_id)
    {
        return  Operation::where('branch_id', $branch_id)->get()->toArray();
    }

    public  function show($branch_id)
    {
        return  Operation::findOrFail($branch_id);
    }

    public  function store($request)
    {
    $data = $request->except('image');
    $branch = Operation::create($data);

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
        return  Operation::findOrFail($branch_id)->update([
            "name" => $request->name
        ]);

    }

    public function destroy($branch_id)
    {
        Operation::findOrFail($branch_id)->delete();
        return true;
    }
}
