<?php

namespace App\Services;

use App\Enums\RoleEnum;
use App\Models\Employee;
use App\Models\Experince;
use App\Models\Salary;
use App\Models\User;
use Carbon\Carbon;

class EmployeeService
{

    public function createEmployee($user_id,$pin,$start_date,$salary,$national_id,$description){
        $user = Employee::create([
            'user_id'=>$user_id,
            'pin'=>$pin,
            'start_date'=>$start_date,
            'national_id'=>$national_id,
            'description'=>$description,
            'salary'=>$salary,

        ]);
        $salary=Salary::create([
            'employee_id'=>$user->user_id,
            'date'=>Carbon::now()->format('Y-m-d'),
            'salary'=>$salary,
        ]);

        return true;
    }


    public function createExperience($request, $employee_id)
{
    $experiences = [];

    foreach ($request->name as $key => $name) {
        $experiences[] = [
            'employee_id' => $employee_id,
            'name' => $name,
            'description' => $request->description[$key],
        ];
    }

    Experince::insert($experiences);
}

public function index()
{
    $result = User::where('role',RoleEnum::EMPLOYEE)->with('employee')
    ->get()->toArray();
    return $result;
}

public function show($employee)
{
    $result = User::where('role',RoleEnum::EMPLOYEE)
    ->with('employee.experince','profileImage')
    ->findOrFail($employee);
    return $result;
}

}
