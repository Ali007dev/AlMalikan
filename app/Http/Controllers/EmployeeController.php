<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    private $employeeService;
    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }
    public function index()
    {
        $employees = $this->employeeService->index();
        return ResponseHelper::success($employees);
    }

    public function store(Request $request)
    {
    }

    public function show($employee)
    {
        $employees = $this->employeeService->show($employee);
        return ResponseHelper::success($employees);
    }

    public function attendancePercent($employee)
    {
        $employees = $this->employeeService->attendancePercent($employee);
        return ResponseHelper::success($employees);
    }
}
