<?php

namespace App\Http\Controllers;

use App\Enums\FileStatusEnum;
use App\Helper\ResponseHelper;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\EmployeeService as ModelsEmployeeService;
use App\Models\Operation;
use App\Models\User;
use App\Services\ApiResponseService;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Constraint\Operator;

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

    public function store(Request $request) {}

    public function update(UpdateEmployeeRequest $request, $id)
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

        if ($request->deleted_services) {
            foreach ($request->deleted_services as $deleted_services) {
                ModelsEmployeeService::where('user_id', $id)
                    ->where('operation_id', $deleted_services)->delete();
            }
        }
        
            if ($request->services) {
                foreach ($request->services as $service) {
                    ModelsEmployeeService::create([
                        'operation_id' => $service,
                        'user_id' => $id
                    ]);
                }
            }


        if ($user->role === 'employee') {
            $employees = $this->employeeService->updateEmployee(
                $id,
                $request

            );
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
