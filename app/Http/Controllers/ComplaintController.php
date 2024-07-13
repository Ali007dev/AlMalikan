<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Http\Requests\ComplaintRequest;
use App\Services\ComplaintService;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{

    private $complaintService;
    public function __construct(ComplaintService $complaintService)
    {
        $this->complaintService = $complaintService;
    }
    public function index()
    {
        $result = $this->complaintService->index();
        return ResponseHelper::success($result);
    }
    public function store(ComplaintRequest $request)
    {
        $result = $this->complaintService->store($request);
        return ResponseHelper::success($result);
    }
    public function update($id, Request $request)
    {
        $result = $this->complaintService->update($id, $request);
        return ResponseHelper::success($result);
    }
    public function destroy(Request $request)
    {
        $complaint_ids = $request->complaint_id;
        $complaint_ids_string = implode(',', $complaint_ids);
        $result = $this->complaintService->destroy($complaint_ids_string);
        return ResponseHelper::success($result);
    }
    public function show($id)
    {
        $result = $this->complaintService->show($id);
        return ResponseHelper::success($result);
    }
}
