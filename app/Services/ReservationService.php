<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Operation;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationService
{
    public  function index($id)
    {
        return  Reservation::where('branch_id', $id)->get();
    }

    public  function archive($id)
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
        $message =
            <<<EOL
Hi {$user->first_name},

Your reservation for {$operation->name} has been added on {$request->date} at {$request->time}.

Price: \${$formattedPrice}

Welcome to Almalikan.
EOL;
        $send = app(WhatsappService::class)->sendWhatsappMessage($user->phone_number, $message);
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
        $res =Reservation::findOrFail($reservation);
       $res ->update([
            'status' => 'declined'
        ]);
        $user = User::findOrFail($res->user_id);
        $operation = Operation::findOrFail($res->operation_id);
        $message =
        <<<EOL
Hi {$user->first_name},

Your reservation for {$operation->name} has been canceled .
We are sorry for that.
Welcome to Almalikan.
EOL;
    $send = app(WhatsappService::class)->sendWhatsappMessage($user->phone_number, $message);

        return $res;
    }


    public function destroy($id)
    {
        return Reservation::whereIn('id', $id)->delete();
    }
}
