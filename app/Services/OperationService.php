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
        $operation = Operation::findOrFail($id);
        $bookings = Reservation::where('operation_id', $id)
                                ->where('date', $date)
                                ->get();

        $availableSlots = [];
        $currentTime = Carbon::parse($operation->from);
        $endTime = Carbon::parse($operation->to);
        $period = $operation->period;

        while ($currentTime->lt($endTime)) {
            $slotEndTime = $currentTime->copy()->addMinutes($period);

            $isAvailable = true;

            foreach ($bookings as $booking) {
                $bookingStart = Carbon::parse($booking->time);
                $bookingEnd = Carbon::parse($booking->end_time);

                if ($currentTime->lt($bookingEnd) && $slotEndTime->gt($bookingStart)) {
                    $isAvailable = false;
                    break;
                }
            }

            if ($isAvailable && $slotEndTime->lte($endTime)) {
                $availableSlots[] = [
                    'from' => $currentTime->format('H:i'),
                    'to' => $slotEndTime->format('H:i'),
                ];
            }

            // Move to the next slot
            $currentTime->addMinutes($period);
        }

        if ($bookings->isEmpty()) {
            $defaultSlots = [];
            $currentTime = Carbon::parse($operation->from);

            while ($currentTime->lt($endTime)) {
                $slotEndTime = $currentTime->copy()->addMinutes($period);

                if ($slotEndTime->lte($endTime)) {
                    $defaultSlots[] = [
                        'from' => $currentTime->format('H:i'),
                        'to' => $slotEndTime->format('H:i'),
                    ];
                }

                $currentTime->addMinutes($period);
            }

            return $defaultSlots;
        }

        return $availableSlots;
    }



}
