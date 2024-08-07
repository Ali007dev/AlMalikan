<?php

namespace App\Services;

use App\Enums\RoleEnum;
use App\Models\Absence;
use App\Models\Attendance;
use App\Models\Day;
use App\Models\Employee;
use App\Models\EmployeeService as EmployeeOperation;
use App\Models\Experince;
use App\Models\Salary;
use App\Models\User;
use Carbon\Carbon;

class EmployeeService
{

    public function createEmployee($user_id, $pin, $start_date, $salary, $national_id, $description, $position, $isFixed,$ratio)
    {
        $user = Employee::create([
            'user_id' => $user_id,
            'pin' => $pin,
            'start_date' => $start_date,
            'national_id' => $national_id,
            'description' => $description,
            'salary' => $salary,
            'position' => $position,
            'isFixed' => $isFixed,
            'ratio' => $ratio

        ]);
        $salary = Salary::create([
            'employee_id' => $user->user_id,
            'date' => Carbon::now()->format('Y-m-d'),
            'salary' => $salary,
        ]);

        return true;
    }


    public function createExperience($request, $employee_id)
    {
        $experiences = [];
        if ($request->has('experiences')) {
            foreach ($request->experiences as $experience) {
                $experiences[] = [
                    'name' => $experience['name'],
                    'description' => $experience['description'],
                    'employee_id' => $employee_id
                ];
            }
        }
        Experince::insert($experiences);
    }



    public function index($id)
    {
        $result = User::where('role', RoleEnum::EMPLOYEE)->with('employee','profileImage','services:id,name,from,to')
            ->where('branch_id',$id)->get()->toArray();
        return $result;
    }

    public function show($employee)
    {
        $result = User::where('role', RoleEnum::EMPLOYEE)
            ->with('employee.experince', 'profileImage','services')
            ->findOrFail($employee);
        return $result;
    }

    public function attendancePercent($user)
    {
        $branch = User::findOrFail($user);
        $absence = Absence::where('user_id', $user)->where('branch_id', $branch->id)->count();
        $days = Day::where('branch_id', $branch->id)->count();
        if ($days === 0) {
            return $absencePercent = null;
        } else {
            $absencePercent = ($absence / $days) * 100;
            return [
                ['absence' => $absencePercent,],
               [ 'attendance' => 100 - $absencePercent]
            ];
        }
    }

    public function addServicesForUser($services, $user)
    {
    $data = [];
    foreach ($services as $service) {
        $data[] = [
            'operation_id' => $service,
            'user_id' => $user,
        ];
    }

    EmployeeOperation::insert(array_unique($data, SORT_REGULAR));
    return true;
}
}
