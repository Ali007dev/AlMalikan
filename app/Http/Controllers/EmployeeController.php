<?php

namespace App\Http\Controllers;

use App\Enums\FileStatusEnum;
use App\Helper\ResponseHelper;
use App\Models\User;
use App\Services\ApiResponseService;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    private $employeeService;
    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }
    public function index($id)
    {
        $employees = $this->employeeService->index($id);
        return ApiResponseService::successResponse($employees);
    }

    public function store(Request $request)
    {
    }

    public function update(Request $request,$id)
    {
        $user = User::findOrFail($id);
        $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'middle_name' => $request->middle_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role'=> $request->role,
                'branch_id'=> $request->branch_id
        ]);

        if($request->image){
            $image = upload($request->image, 'user/images');
            $user->image()->delete();
            $user->image()->create(
                [
                    'image' =>$image,
                    'type' => FileStatusEnum::PROFILE
                ]
            );
        }

        if ($user->role === 'employee'){
        $employees = $this->employeeService->updateEmployee($id,
        $request->pin,$request->start_date,
        $request->salary,
        $request->national_id,
        $request->description,
        $request->position,
        $request->isFixed,
        $request->ratio,);
        }
        return $user;


    }

    public function show($employee)
    {
        $employees = $this->employeeService->show($employee);
        return ApiResponseService::successResponse($employees);
    }

    public function attendancePercent($employee)
    {
        $employees = $this->employeeService->attendancePercent($employee);
        return ApiResponseService::successResponse($employees);
    }


}
