<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;

class WhatsappService
{

    public function sendWhatsappMessage($to, $message)
    {
        $params = array(
            'token' => 'qejsdhdrlkrc0xgh',
            'to' => $to,
            'body' => $message
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ultramsg.com/instance92570/messages/chat",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }


    public function notify()
    {


        $tomorrow = Carbon::now()->addDay()->format('Y-m-d');
        $reservations = Reservation::where('date', $tomorrow)->get();

        $userIds = $reservations->pluck('user_id')->unique();

        $users = User::whereIn('id', $userIds)->get();

        foreach ($users as  $user) {
            $message =
                <<<EOL
 {$user->first_name} مرحبا
نود تذكيرك بموعد الحجز غدا في مركز الملكان,

شكرا جزيلا.
أهلا بكم في مركز الملكان
EOL;
            $this->sendWhatsappMessage($user->phone_number, $message);
        }
    }
}
