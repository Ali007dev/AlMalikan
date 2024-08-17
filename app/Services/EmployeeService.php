<?php

namespace App\Services;

use App\Enums\FileStatusEnum;
use App\Enums\RoleEnum;
use App\Models\Absence;
use App\Models\Attendance;
use App\Models\Branch;
use App\Models\Day;
use App\Models\Employee;
use App\Models\EmployeeService as EmployeeOperation;
use App\Models\Experince;
use App\Models\Late;
use App\Models\Salary;
use App\Models\User;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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


    public function updateEmployee($user_id, $request)
    {
        $user = Employee::where('user_id', $user_id);
        $user->update(
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

    public function report($id,$request)
    {
        $user = User::where('role', RoleEnum::EMPLOYEE)->with('employee', 'profileImage', 'services:id,name,from,to')
            ->findOrFail($id);

        $attendance = $this->attendancePercentCount($id,$request);


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Position');
        $sheet->setCellValue('D1', 'Salary');
        $sheet->setCellValue('E1', 'description');
        $sheet->setCellValue('F1', 'salary fixed value');
        $sheet->setCellValue('G1', 'ratio');
        $sheet->setCellValue('H1', 'start_date');
        $sheet->setCellValue('I1', 'Attendance');
        $sheet->setCellValue('J1', 'Absence');
        $sheet->setCellValue('K1', 'Late');

        $sheet->setCellValue('A2', $user->id);
        $sheet->setCellValue('B2', $user->first_name . ' ' . $user->middle_name . '' . $user->last_name);
        $sheet->setCellValue('C2', $user->employee->position);
        $sheet->setCellValue('D2', $user->employee->salary);
        $sheet->setCellValue('E2', $user->employee->description);
        $sheet->setCellValue('F2', $user->employee->isFixed);
        $sheet->setCellValue('G2', $user->employee->ratio);
        $sheet->setCellValue('H2', $user->employee->start_date);
        $sheet->setCellValue('I2', $attendance['attendance']);
        $sheet->setCellValue('J2', $attendance['absence']);
        $sheet->setCellValue('K2', $attendance['late']);

        $fileName = 'EmployeeData.xlsx';
        $filePath = storage_path('app/public/reports') . '/' . $fileName;

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        $fileUrl = asset('storage/reports/' . $fileName);

        return response()->json(['file_url' => $fileUrl]);
    }


    public function reportAll($id,$request)
{
    $users = User::where('branch_id',$id)->where('role', RoleEnum::EMPLOYEE)->with('employee', 'profileImage', 'services:id,name,from,to')->get();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $cells = ['A1', 'B1', 'C1', 'D1', 'E1', 'F1', 'G1', 'H1', 'I1', 'J1', 'K1'];
$colors = [
    'FF0000', // أحمر
    '6B8DF9', // أخضر
    '6AA4FA', // أزرق
    'B2C4FC', // أصفر
    'C1B7BC', // ماجنتا
    'D6D0D3', // سيان
    'E2E2E2', // رمادي
    '00B050', // برتقالي
    'FF0000', // بنفسجي
    'FF0000', // مارون
    'FFFF89'  // تركواز
];

$gray = 'D3D3D3'; // رمادي فاتح
$white = 'FFFFFF'; // أبيض (يمكن تغييره إذا أردت لونًا آخر)

foreach ($cells as $index => $cell) {
    $sheet->getStyle($cell)->getFill()
        ->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setARGB($colors[$index]);
}
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Name');
    $sheet->setCellValue('C1', 'Position');
    $sheet->setCellValue('D1', 'Salary');
    $sheet->setCellValue('E1', 'Description');
    $sheet->setCellValue('F1', 'Salary Fixed Value');
    $sheet->setCellValue('G1', 'Ratio');
    $sheet->setCellValue('H1', 'Start Date');
    $sheet->setCellValue('I1', 'Attendance');
    $sheet->setCellValue('J1', 'Absence');
    $sheet->setCellValue('K1', 'Late');

    $row = 2;
foreach ($users as $user) {
    $attendance = $this->attendancePercentCount($user->id,$request);

    $fillColor = $row % 2 === 0 ? $gray : $white;

    $sheet->getStyle('A' . $row . ':K' . $row)->getFill()
        ->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FF' . $fillColor);

        $sheet->setCellValue('A' . $row, $user->id);
        $sheet->setCellValue('B' . $row, $user->first_name . ' ' . ($user->middle_name ?? '') . ' ' . $user->last_name);
        $sheet->setCellValue('C' . $row, $user->employee->position ?? 'N/A');
        $sheet->setCellValue('D' . $row, $user->employee->salary ?? 'N/A');
        $sheet->setCellValue('E' . $row, $user->employee->description ?? 'N/A');
        $sheet->setCellValue('F' . $row, $user->employee->isFixed ?? 'N/A');
        $sheet->setCellValue('G' . $row, $user->employee->ratio ?? 'N/A');
        $sheet->setCellValue('H' . $row, $user->employee->start_date ?? 'N/A');
        $sheet->setCellValue('I' . $row, $attendance['attendance'] ?? 'N/A');
        $sheet->setCellValue('J' . $row, $attendance['absence'] ?? 'N/A');
        $sheet->setCellValue('K' . $row, $attendance['late'] ?? 'N/A');
        $row++;
    }

    $fileName = 'AllEmployeesData.xlsx';
    $filePath = storage_path('app/public/reports') . '/' . $fileName;

    $writer = new Xlsx($spreadsheet);
    $writer->save($filePath);

    $fileUrl = asset('storage/reports/' . $fileName);

    return response()->json(['file_url' => $fileUrl]);
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
        $days = Day::where('branch_id', $branch->branch_id)->count();
        if ($days === 0) {
            return $absencePercent = null;
        } else {
            $absencePercent = ($absence / $days) * 100;
            return [
                'absence' => $absencePercent,
                'attendance' => 100 - $absencePercent,
                'total' => 100
            ];
        }
    }

    public function attendancePercentCount($userId, $date)
{
    $user = User::findOrFail($userId);
    $date = Carbon::createFromFormat('Y-m-d', $date);
    $startOfMonth = $date->startOfMonth()->toDateString();
    $endOfMonth = $date->endOfMonth()->toDateString();

    // تحديد الحضور والغياب والتأخير خلال شهر معين
    $attendance = Attendance::where('user_id', $user->id)
                            ->where('branch_id', $user->branch_id)
                            ->whereBetween('date', [$startOfMonth, $endOfMonth])
                            ->count();
    $absence = Absence::where('user_id', $user->id)
                      ->where('branch_id', $user->branch_id)
                      ->whereBetween('date', [$startOfMonth, $endOfMonth])
                      ->count();
    $late = Late::where('employee_id', $user->id)
                ->where('branch_id', $user->branch_id)
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->count();

    // عدد الأيام في الشهر
    $days = Day::where('branch_id', $user->branch_id)
               ->whereBetween('date', [$startOfMonth, $endOfMonth])
               ->count();

    return [
        'absence' => $absence,
        'late' => $late,
        'attendance' => $attendance,
        'total' => $days
    ];
}

    public function addServicesForUser($services, $user)
    {
        if ($services) {
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
