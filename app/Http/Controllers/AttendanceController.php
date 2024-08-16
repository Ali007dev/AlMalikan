<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Http\Requests\AttendanceFileRequest;
use App\Services\AttendanceService;
use App\Services\FingerPrintService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    private $attendanceService;
    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function getUserAttendance($user)
    {
        $result  = $this->attendanceService->getUserAttendance($user);
        return ResponseHelper::success($result);
    }

    public function getDailyAttendance($user)
    {
        $result  = $this->attendanceService->getDailyAttendance($user);
        return ResponseHelper::success($result);
    }

    public function getMonthlyAttendance($user)
    {
        $result  = $this->attendanceService->getDailyAttendance($user);
        return ResponseHelper::success($result);
    }

    public function file(AttendanceFileRequest $request)
    {

        $result  = app(FingerPrintService::class)->processAttendanceFile($request);
        return ResponseHelper::success($result);
    }
}
