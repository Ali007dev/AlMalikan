<?php

namespace App\Services;

use App\Enums\FileStatusEnum;
use App\Models\Branch;
use App\Models\Operation;
use App\Models\Reservation;
use App\Models\ServiceDiscount;
use Carbon\Carbon;

class OperationService
{

    public  function index($branch_id)
    {
        return  Operation::where('branch_id', $branch_id)->with('image')->get()->toArray();
    }

    public  function show($branch_id)
    {
        return  Operation::with('image')->findOrFail($branch_id);
    }

    public  function store($request)
    {
    $data = $request->except('image');
    $branch = Operation::create($data);

    if ($request->hasFile('image')){
      $image = upload($request->image, 'operations/images');
      $branch->image()->create([
        'image'=>$image,
        'type'=> FileStatusEnum::OTHER
    ]);
}
    return  $branch;


    }

    public function update($branch_id, $request)
    {
        return  Operation::findOrFail($branch_id)->update([
            "name" => $request->name
        ]);

    }

    public function destroy($branch_id)
    {
        Operation::findOrFail($branch_id)->delete();
        return true;
    }



    public function createDiscount($request, $branch_id)
    {
        $discounts = [];
            foreach ($request->services as $discount) {
                $discounts[] = [
                    'operation_id' => $discount,
                    'value' => $request->value,
                    'from' => $request->from,
                    'to' => $request->to,
                    'branch_id' => $branch_id
                ];

        }
       return ServiceDiscount::insert($discounts);

    }
    public function availableTime($id, $date)
    {
        // Fetch the operation with the given ID or fail if not found
        $operation = Operation::findOrFail($id);

        // Fetch all bookings for this operation on the given date
        $bookings = Reservation::where('operation_id', $id)
                                ->where('date', $date)
                                ->get();

        // Convert operation times from and to into Carbon instances for easy manipulation
        $operationStart = Carbon::parse($date . ' ' . $operation->from);
        $operationEnd = Carbon::parse($date . ' ' . $operation->to);

        // Initialize the available slots with the full operation window
        $availableSlots = [
            ['start' => $operationStart, 'end' => $operationEnd]
        ];

        // Loop through each booking and adjust the availableSlots accordingly
        foreach ($bookings as $booking) {
            $bookingStart = Carbon::parse($date . ' ' . $booking->time);
            $bookingEnd = Carbon::parse($date . ' ' . $booking->end_time);

            $newSlots = [];

            foreach ($availableSlots as $slot) {
                if ($bookingStart <= $slot['end'] && $bookingEnd >= $slot['start']) {
                    if ($bookingStart > $slot['start']) {
                        $newSlots[] = ['start' => $slot['start'], 'end' => $bookingStart];
                    }

                    if ($bookingEnd < $slot['end']) {
                        $newSlots[] = ['start' => $bookingEnd, 'end' => $slot['end']];
                    }
                } else {
                    $newSlots[] = $slot;
                }
            }

            $availableSlots = $newSlots;
        }

        $formattedSlots = array_map(function ($slot) {
            return ['start' => $slot['start']->toTimeString(), 'end' => $slot['end']->toTimeString()];
        }, $availableSlots);

        return $formattedSlots;
    }

}
