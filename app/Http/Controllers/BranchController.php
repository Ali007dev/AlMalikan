<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Http\Requests\BranchRequest;
use App\Services\BranchService;
use Illuminate\Http\Request;

class BranchController extends Controller
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

    public function all($id)
    {
        $result = $this->branchService->all($id);
        return ResponseHelper::success($result);
    }
    public function store(BranchRequest $request)
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

    public function getStatisticForBranch($id)
    {
        $result = $this->branchService->getStatisticForBranch($id);
        return ResponseHelper::success($result);
    }
    public function getDigramStatisticForBranch(Request $request ,$id)
    {
        $result = $this->branchService->getDigramStatisticForBranch($request,$id);
        return ResponseHelper::success($result);
    }
    public function getYearData(Request $request ,$id)
    {
        $result = $this->branchService->getYearData($request,$id);
        return ResponseHelper::success($result);
    }


}
