<?php

namespace App\Services;

use App\Http\Resources\ReservationResource;
use App\Models\Branch;
use App\Models\Operation;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ReservationService
{
    public  function index($id)
    {

        return  Reservation::where('branch_id', $id)->get();
    }

    public  function archive($id)
    {
        return  Reservation::where('status','!=','waiting')->where('branch_id', $id)->where('date', '<=', Carbon::now()->format('Y-m-d'))->get()->toArray();
    }

    public  function recent($id)
    {
        return  Reservation::where('branch_id', $id)->where('date', '>=', Carbon::now()->format('Y-m-d'))->get()->toArray();
    }

    public  function archiveWithUser($id)
    {
        return  User::where('id', $id)->with('archiveCustomerReservation')->get()->toArray();
    }
    public  function recentWithUser($id)
    {
        return  User::where('id', $id)->with('recentCustomerReservation')->get()->toArray();
    }

    public  function archiveMe()
    {
        return  User::where('id', Auth::user()->id)->with('archiveCustomerReservation')->get();
    }
    public  function recentMe()
    {
        return  User::where('id', Auth::user()->id)->with('recentCustomerReservation')->get();
    }

    public  function me()
    {
        return  Reservation::where('user_id', Auth::user()->id)->get()->toArray();
    }

    public  function show($operation)
    {
        return  Reservation::findOrFail($operation);
    }

    public function userPercentage($operation)
    {
        $userCount = 0;
        $totalReservations = 0;
        $reservations = Reservation::get();


        foreach ($reservations as $reservation) {

            $totalReservations++;
            if ($reservation['user_id'] == $operation) {

                $userCount++;
            }
        }

        if ($totalReservations != 0) {
            $result =
                [
                    'user_booking' => ($userCount / $totalReservations) * 100,
                    'other_booking' => 100 - ($userCount / $totalReservations) * 100,
                    'total' => 100
                ];
        }

        if ($totalReservations == 0) {
            $result =
                [
                    'user_booking' => 0,
                    'other_booking' => 0,
                    'total' => 100
                ];
        }

        return $result;
    }
    public  function showUser($user)
    {
        return  User::where('role', 'user')->with('customerReservation')->findOrFail($user);
    }

    public  function showEmployee($user)
    {
        return  User::where('role', 'employee')->with('employeeReservation')->findOrFail($user);
    }

    public  function store($request)
    {
        $user = User::findOrFail($request['user_id']);
        $operation = Operation::findOrFail($request['operation_id']);
        $formattedPrice = number_format($operation->price, 2);

        $reservation = Reservation::create($request->all());
//         $message =
//             <<<EOL
// Hi {$user->first_name},

// Your reservation for {$operation->name} has been added on {$request->date} at {$request->time}.

// Price: \${$formattedPrice}

// Welcome to Almalikan.
// EOL;
//         $send = app(WhatsappService::class)->sendWhatsappMessage($user->phone_number, $message);
        return $reservation;
    }
    public  function storeMe($request)
    {
        $request['user_id'] = Auth::user()->id;
        return Reservation::create($request->all());
    }

    public function update($reservation, $request)
    {
        return  Reservation::findOrFail($reservation)->update($request->all());
    }

    public function decline($reservation)
    {
        $res = Reservation::findOrFail($reservation);
        $res->update([
            'status' => 'declined'
        ]);
        $user = User::findOrFail($res->user_id);
        $operation = Operation::findOrFail($res->operation_id);
        $formattedPrice = number_format($operation->price, 2);

//         $message =
//             <<<EOL
// Hi {$user->first_name},

// Your reservation for {$operation->name} has been added on {$res->date} at {$res->time}.

// Price: \${$formattedPrice}

// Welcome to Almalikan.
// EOL;
//         $send = app(WhatsappService::class)->sendWhatsappMessage($user->phone_number, $message);

        return $res;
    }


    public function accept($reservation)
    {
        $res = Reservation::findOrFail($reservation);
        $res->update([
            'status' => 'done'
        ]);
        $user = User::findOrFail($res->user_id);
        $operation = Operation::findOrFail($res->operation_id);
//         $message =
//             <<<EOL
// Hi {$user->first_name},

// Your reservation for {$operation->name} has been canceled .
// We are sorry for that.
// Welcome to Almalikan.
// EOL;
//         $send = app(WhatsappService::class)->sendWhatsappMessage($user->phone_number, $message);

        return $res;
    }


    public function destroy($id)
    {
        return Reservation::whereIn('id', $id)->delete();
    }



    public function report($id,$dateInput)
    {
        $date = Carbon::createFromFormat('Y-m-d', $dateInput);
        $startOfMonth = $date->startOfMonth()->toDateString();
        $endOfMonth = $date->endOfMonth()->toDateString();

        $bookings = Reservation::where('branch_id',$id)->whereBetween('date', [$startOfMonth, $endOfMonth])->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Date');
        $sheet->setCellValue('B1', 'Time');
        $sheet->setCellValue('C1', 'Branch Name');
        $sheet->setCellValue('D1', 'Service Name');
        $sheet->setCellValue('E1', 'Customer Name');

        $row = 2;
        foreach ($bookings as $booking) {

            $sheet->setCellValue('A' . $row, $booking['date']);
            $sheet->setCellValue('B' . $row, $booking['time']);
           // $sheet->setCellValue('C' . $row, $booking['branchName']);
            $sheet->setCellValue('D' . $row,$booking['service']['name']);
            $sheet->setCellValue('E' . $row, $booking['customer']['first_name'] . ' ' . $booking['customer']['last_name']);
            $row++;
        }


        $fileName = 'AllEmployeesData.xlsx';
        $filePath = storage_path('app/public/reports') . '/' . $fileName;

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        $fileUrl = asset('storage/reports/' . $fileName);

        return response()->json(['file_url' => $fileUrl]);
    }


}
