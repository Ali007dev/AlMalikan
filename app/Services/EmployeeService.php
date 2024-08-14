<?php

namespace App\Services;

use App\Enums\FileStatusEnum;
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

    public function createEmployee($user_id, $pin, $start_date, $salary, $national_id, $description, $position, $isFixed, $ratio)
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


    public function updateEmployee($user_id,$request)
    {
        $user = Employee::where('user_id',$user_id);
        $user   ->update(
            $request->only([
            'pin',
            'start_date',
             'national_id',
            'description',
            'salary',
             'position',
            'isFixed',
             'ratio'
             ])
        );

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
        $result = User::where('role', RoleEnum::EMPLOYEE)->with('employee', 'profileImage', 'services:id,name,from,to')
            ->where('branch_id', $id)->get()->toArray();
        return $result;
    }

    public function show($employee)
    {
        $result = User::where('role', RoleEnum::EMPLOYEE)
            ->with('employee.experince', 'profileImage', 'services')
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
                ['attendance' => 100 - $absencePercent]
            ];
        }
    }

    public function addServicesForUser($services, $user)
    {
        if($services){
        $data = [];
        foreach ($services as $service) {
            $data[] = [
                'operation_id' => $service,
                'user_id' => $user,
            ];
        }

        EmployeeOperation::insert(array_unique($data, SORT_REGULAR));
    }
        return true;
    }

    public function update($request, $id)
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
            foreach ($request->deleted_services as $deleted_service) {
                EmployeeOperation::where('user_id', $id)
                    ->where('operation_id', $deleted_service)->delete();
            }
        }

            if ($request->services) {
                foreach ($request->services as $service) {
                    EmployeeOperation::create([
                        'operation_id' => $service,
                        'user_id' => $id
                    ]);
                }
            }


        if ($user->role === 'employee') {
            $employees = $this->updateEmployee(
                $id,
                $request

            );
        }
        return $user;
    }
}
