<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\ServiceDiscount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ServiceDiscountService
{
    public  function index($id)
    {
        return  ServiceDiscount::where('branch_id',$id)->get()->toArray();
    }

    public  function me()
    {
        return  ServiceDiscount::where('user_id',Auth::user()->id)->get()->toArray();
    }

    public  function show($branch_id)
    {
        return  ServiceDiscount::findOrFail($branch_id);
    }

    public  function store($request)
    {
     return ServiceDiscount::create($request->all());
    }

    public function update($reservation, $request)
    {
        return  ServiceDiscount::findOrFail($reservation)->update($request->all());
    }

    public function destroy($id)
    {
        return ServiceDiscount::whereIn('id',$id)->delete();
    }
}
