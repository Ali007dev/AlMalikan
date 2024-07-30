<?php

namespace App\Services;

use App\Enums\FileStatusEnum;
use App\Enums\RoleEnum;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\Operation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

    public function getStatisticForBranch($branch_id)
    {
        $counts = User::selectRaw('
            SUM(CASE WHEN users.role = ? THEN 1 ELSE 0 END) AS employees,
            SUM(CASE WHEN users.role = ? THEN 1 ELSE 0 END) AS customers,
            SUM(CASE WHEN employees.position = ? THEN 1 ELSE 0 END) AS doctors
        ', [RoleEnum::EMPLOYEE, RoleEnum::USER, 'doctor'])
        ->leftJoin('employees', 'users.id', '=', 'employees.user_id')
        ->where('users.branch_id', $branch_id)
        ->first();

        $services = Operation::where('branch_id', $branch_id)->count();
        return [
            'total_employees' => $counts->employees ?? 0 ,
            'total_customers' => $counts->customers ?? 0,
            'total_doctors' => $counts->doctors ?? 0,
            'total_services' => $services ?? 0
        ];
    }
}
