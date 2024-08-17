<?php
namespace App\Services;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Support\Facades\File;

class FingerPrintService
{
public function processAttendanceFile($request) {
    $filePath = $request->file('file');
    $data = json_decode($filePath->get(), true);
    $attendances = [];
    foreach ($data['Row'] as $entry) {
        $date = explode(' ', $entry['DateTime'])[0];
        $time = explode(' ', $entry['DateTime'])[1];
        $pin = $entry['PIN'];
        $status = $entry['Status'];

        if (!isset($attendances[$date])) {
            $attendances[$date] = [];
        }
        $user = User::where('id', $pin)->first();
        if (!$user) {
            continue; // Skip this entry if no user is found
        }
        if (!isset($attendances[$date][$pin])) {
          $id =  User::where('id',$attendances[$date][$pin])->get();
            $attendances[$date][$pin] = [
                'user_id' =>$id-> rendom()->id,
                'checkIn' => null,
                'checkOut' => null,
                'date' => $date,
                'branch_id' => 1
            ];
        }

        if ($status == '0' && is_null($attendances[$date][$pin]['checkIn'])) {
            $attendances[$date][$pin]['checkIn'] = $time;
        } elseif ($status == '1') {
            $attendances[$date][$pin]['checkOut'] = $time;
        }
    }

    foreach ($attendances as $date => $users) {
        foreach ($users as $userAttendance) {
            Attendance::create($userAttendance);
        }
    }
}

}

