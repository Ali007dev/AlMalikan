<?php

namespace App\Services;

use App\Models\Late;

class LateService
{
    public  function index()
    {
        return  Late::with('employee.profileImage')->get()->toArray();
    }

    public  function show($late_id)
    {
        return  Late::findOrFail($late_id);
    }

    public  function store($request)
    {
     return   Late::create($request->all());
    }

    public function update($late_id, $request)
    {
        return  Late::findOrFail($late_id)->update($request->all());

    }

    public function destroy($late_id)
    {
        Late::findOrFail($late_id)->delete();
        return true;
    }
}
