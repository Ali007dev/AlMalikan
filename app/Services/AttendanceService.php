<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\User;

class AttendanceService
{

    public function getUserAttendance($userId)
    {
        $user = User::findOrFail($userId);
        $absence = $user->absence()->get()->map(function ($item) {
            $item['isAbsence'] = true;
            return $item;
        });
        $attendance = $user->attendance()->get()->map(function ($item) {
            $item['isAbsence'] = false;
            return $item;
        });
 
        $result = collect([$absence, $attendance])
            ->flatten()
            ->sortByDesc('date')
            ->values()
            ->toArray();
        return $result;
    }


    public  function index()
    {
        return  Branch::get()->toArray();
    }

    public  function show($branch_id)
    {
        return  Branch::findOrFail($branch_id);
    }

    public  function store($request)
    {
        return   Branch::create([
            "name" => $request->name,
        ]);
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
}
