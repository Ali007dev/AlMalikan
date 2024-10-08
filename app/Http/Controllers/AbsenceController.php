<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    private $branchService;
    public function __construct(BranchService $branchService)
    {
        $this->branchService = $branchService;
    }
    public function index()
    {
        $result = $this->branchService->index();
        return ResponseHelper::success($result);
    }
    public function store(Request $request)
    {
        $result = $this->branchService->store($request);
        return ResponseHelper::success($result);
    }
    public function update($id, Request $request)
    {
        $result = $this->branchService->update($id, $request);
        return ResponseHelper::success($result);
    }
    public function destroy($id)
    {
        $result = $this->branchService->destroy($id);
        return ResponseHelper::success($result);
    }
    public function show($id)
    {
        $result = $this->branchService->show($id);
        return ResponseHelper::success($result);
    }
}
