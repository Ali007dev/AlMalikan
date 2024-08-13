<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationService
{
    public  function index($id)
    {
        return  Reservation::where('branch_id',$id)->get()->toArray();
    }

    public  function me()
    {
        return  Reservation::where('user_id',Auth::user()->id)->get()->toArray();
    }

    public  function show($branch_id)
    {
        return  Reservation::findOrFail($branch_id);
    }

    public  function store($request)
    {
     return Reservation::create($request->all());
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

    public function destroy($id)
    {
        return Reservation::whereIn('id',$id)->delete();
    }
}
