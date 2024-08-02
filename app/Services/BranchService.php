<?php

namespace App\Services;

use App\Enums\FileStatusEnum;
use App\Enums\RoleEnum;
use App\Models\Absence;
use App\Models\Attendance;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\Late;
use App\Models\Operation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BranchService
{

    public  function index()
    {
        return  Branch::withCount('client', 'employee')->get()->toArray();
    }

    public  function show($branch_id)
    {
        return  Branch::findOrFail($branch_id);
    }

    public  function store($request)
    {
        $data = $request->except('image');
        $branch = Branch::create($data);

        if ($request->hasFile('image')) {
            $image = upload($request->image, 'branches/images');
            $branch->image()->create([
                'image' => $image,
                'type' => FileStatusEnum::OTHER
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
            'total_employees' => $counts->employees ?? 0,
            'total_customers' => $counts->customers ?? 0,
            'total_doctors' => $counts->doctors ?? 0,
            'total_services' => $services ?? 0

        ];
    }


    public function getDigramStatisticForBranch($request, $branch_id)
    {
        $attendances = [];
        $absence = [];
        $late = [];

        if ($request->status === 'monthly') {
            $date = Carbon::parse($request->date)->format('Y-m');
            $data = $this->getMonthData($branch_id, $date);
           return $this->countArray($data['attendances'],$data['absences'],$data['lates']);
        }
    }


    public function getMonthData($branch_id, $date)
    {
        list($year, $month) = explode('-', $date);
        $attendance = Attendance::where('branch_id', $branch_id)->whereYear('date', $year)->whereMonth('date', $month)->get();
        $absence = Absence::where('branch_id', $branch_id)->whereYear('date', $year)->whereMonth('date', $month)->get();
        $late = Late::where('branch_id', $branch_id)->whereYear('date', $year)->whereMonth('date', $month)->get();
        return [
            'attendances' => $attendance,
             'absences' => $absence,
            'lates' => $late
        ];
    }


    public function getYearData($branch_id, $date)
    {
        list($year, $month) = explode('-', $date);
        $attendance = Attendance::where('branch_id', $branch_id)->whereYear('date', $year)->get();
        $absence = Absence::where('branch_id', $branch_id)->whereYear('date', $year)->get();
        $late = Late::where('branch_id', $branch_id)->whereYear('date', $year)->get();
        return [
            ['attendances' => $attendance,],
            [ 'absences' => $absence,],
            ['lates' => $late,]
        ];
    }


    public function countArray($attendances, $absences, $lates)
    {

        $result = [];
        $attendance_pieces = !empty($attendances) ? array_chunk($attendances->toArray(), 5) : [];
        $absence_pieces = !empty($absences) ? array_chunk($absences->toArray(), 5) : [];
        $late_pieces = !empty($lates) ? array_chunk($lates->toArray(), 5) : [];

        foreach (range(0, 3) as $index) {
            $attendance_count = isset($attendance_pieces[$index]) ? count($attendance_pieces[$index]) : 0;
            $absences_count = isset($absence_pieces[$index]) ? count($absence_pieces[$index]):0;
            $lates_count = isset($late_pieces[$index]) ? count($late_pieces[$index]) : 0;
            $attendanceCountWithoutLate =  $attendance_count - ($lates_count + $absences_count );

            if( $attendance_count > 0){
            $absencePercent = $absences_count *100 / $attendance_count;
            $attendancePercent = $attendanceCountWithoutLate *100 / $attendance_count;
            $latePercent = $lates_count *100 / $attendance_count;
            }
            else {
                $absencePercent = 0;
                $attendancePercent = 0;
                $latePercent = 0 ;
            }
            $result["week_" . ($index + 1)] = [

                'absences_count' => $absencePercent,
                'attendance_count' => $attendancePercent,
                'lates_count' => $latePercent ,
            ];
        }

        return $result;

}
}
