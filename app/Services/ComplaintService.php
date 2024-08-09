<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Complaint;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ComplaintService
{
    public  function index($id)
    {
        return  Complaint::where('branch_id',$id)->get()->toArray();
    }

    public  function show($branch_id)
    {
        return  Complaint::findOrFail($branch_id);
    }

    public  function store($request)
    {
     $request['user_id']= Auth::user()->id;
     $request['date']= Carbon::now()->format('Y-m-d');
     return Complaint::create($request->all());
    }

    public function update($complaint_id, $request)
    {
        return  Complaint::findOrFail($complaint_id)->update([$request]);
    }

    public function destroy($ids): void
    {
        $ids = explode(',',$ids);
        Complaint::whereIn('id',$ids)->delete();
    }
}
