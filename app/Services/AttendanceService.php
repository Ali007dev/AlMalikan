<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\User;

class AttendanceService
{

    public function getUserAttendance($user)
    {
        $result = User::where('id', $user)->with('attendance')->get()->toArray();
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
