<?php
namespace App\Services;

use App\Models\Attendance;
use App\Models\Branch;
use App\Models\Late;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class FingerPrintService
{
    public function processAttendanceFile($request) {
        $filePath = $request->file('file');
        $branch_id = $request->branch_id;
        $branch = Branch::findOrFail($branch_id);
        $data = json_decode($filePath->get(), true);
        $attendances = [];

        foreach ($data['Row'] as $entry) {
            $dateTime = explode(' ', $entry['DateTime']);
            $date = $dateTime[0];
            $time = $dateTime[1];
            $pin = $entry['PIN'];
            $status = $entry['Status'];

            $user = User::where('id', $pin)->first();  // Assuming 'pin' is the correct field
            if ($user) {
                if (!isset($attendances[$date][$pin])) {
                    $attendances[$date][$pin] = [
                        'user_id' => $user->id,
                        'checkIn' => null,
                        'checkOut' => null,
                        'date' => $date,
                        'branch_id' => $branch_id
                    ];
                }

                if ($status == '0' && is_null($attendances[$date][$pin]['checkIn'])) {
                    $attendances[$date][$pin]['checkIn'] = $time;
                    $checkInTime = Carbon::createFromFormat('H:i:s', $time);
                    $startTime = Carbon::createFromTimeString($branch->start_time);
                    if ($time > $branch->start_time) {
                        $hoursLate = $checkInTime->diffInHours($startTime);

                        $late = [
                            'employee_id' => $user->id,
                            'date' => $date,
                            'hours' =>  $hoursLate ,
                            'branch_id' => $branch_id
                        ];
                        Late::insert($late);
                    }
                } elseif ($status == '1' && is_null($attendances[$date][$pin]['checkOut'])) {
                    $attendances[$date][$pin]['checkOut'] = $time;
                }
            }
        }

        // Save the collected attendance data
        foreach ($attendances as $date => $users) {
            foreach ($users as $userAttendance) {
                Attendance::create($userAttendance);
            }
        }
    }



}

