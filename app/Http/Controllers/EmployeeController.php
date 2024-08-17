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

    public function report($id,Request $request)
    {
        $employees = $this->employeeService->report($id,$request->date);
        return ApiResponseService::successResponse($employees);
    }
    public function reportAll($id,Request $request)
    {
        $employees = $this->employeeService->reportAll($id,$request->date);
        return ApiResponseService::successResponse($employees);
    }

    public function store(Request $request) {}

    public function update(UpdateEmployeeRequest $request, $id)
    {

        $employees = $this->employeeService->update($request,$id);
        return ApiResponseService::successResponse($employees);

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
