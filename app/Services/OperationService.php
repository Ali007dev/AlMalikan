<?php

namespace App\Services;

use App\Enums\FileStatusEnum;
use App\Models\Branch;
use App\Models\Operation;
use App\Models\ServiceDiscount;

class OperationService
{

    public  function index($branch_id)
    {
        return  Operation::where('branch_id', $branch_id)->with('image')->get()->toArray();
    }

    public  function show($branch_id)
    {
        return  Operation::with('image')->findOrFail($branch_id);
    }

    public  function store($request)
    {
    $data = $request->except('image');
    $branch = Operation::create($data);

    if ($request->hasFile('image')){
      $image = upload($request->image, 'operations/images');
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



    public function createDiscount($request, $branch_id)
    {
        $discounts = [];
            foreach ($request->services as $discount) {
                $discounts[] = [
                    'operation_id' => $discount,
                    'value' => $request->value,
                    'from' => $request->from,
                    'to' => $request->to,
                    'branch_id' => $branch_id
                ];

        }
       return ServiceDiscount::insert($discounts);

    }
}
