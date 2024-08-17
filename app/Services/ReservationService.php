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


        $cells = ['A1', 'B1', 'C1', 'D1', 'E1', 'F1', 'G1','K1'];
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

        $gray = 'D3D3D3';
        $white = 'FFFFFF';

        foreach ($cells as $index => $cell) {
            $sheet->getStyle($cell)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB($colors[$index]);
        }
        $sheet->setCellValue('A1', 'Date');
        $sheet->setCellValue('B1', 'Time');
        $sheet->setCellValue('C1', 'Branch Name');
        $sheet->setCellValue('D1', 'Service Name');
        $sheet->setCellValue('E1', 'Customer Name');
        $sheet->setCellValue('F1', 'employee Name');
        $sheet->setCellValue('G1', 'total');



        $row = 2;
        $total_price = 0;
        foreach ($bookings as $booking) {
            $fillColor = $row % 2 === 0 ? $gray : $white;
            $total_price = $booking['service']['price'] + $total_price;
            $sheet->getStyle('A' . $row . ':K' . $row)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF' . $fillColor);

            $sheet->setCellValue('A' . $row, $booking['date']?? 'N/A');
            $sheet->setCellValue('B' . $row, $booking['time']?? 'N/A');
            $sheet->setCellValue('C' . $row, $booking['branch']['name']?? 'N/A');
            $sheet->setCellValue('D' . $row,$booking['service']['name']?? 'N/A');
            $sheet->setCellValue('G' . $row,$booking['service']['price']?? 'N/A');

            $sheet->setCellValue('E' . $row, $booking['customer']['first_name'] ?? 'N/A' . ' ' . $booking['customer']['last_name'] ?? 'N/A');
            if (isset($booking['employee']) && $booking['employee'] !== null) {
                $employeeFirstName = $booking['employee']['first_name'] ?? 'N/A';
                $employeeLastName = $booking['employee']['last_name'] ?? 'N/A';
                $employeeFullName = $employeeFirstName . ' ' . $employeeLastName;
            } else {
                $employeeFullName = 'N/A';
            }
            $sheet->setCellValue('F' . $row, $employeeFullName);
            $row++;
        }
        $sheet->setCellValue('G' . $row, $total_price);



        $fileName = 'AllEmployeesData.xlsx';
        $filePath = storage_path('app/public/reports') . '/' . $fileName;

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        $fileUrl = asset('storage/reports/' . $fileName);

        return response()->json(['file_url' => $fileUrl]);
    }


}
