<?php
namespace App\Services;

use App\Models\Attendance;
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

        if (!isset($attendances[$date][$pin])) {
            $attendances[$date][$pin] = [
                'user_id' => $pin,
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

