<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Http\Requests\LateRequest;
use App\Services\LateService;
use Illuminate\Http\Request;

class LateController extends Controller
{
    private $lateService;
    public function __construct(LateService $lateService)
    {
        $this->lateService = $lateService;
    }
    public function index()
    {
        $result = $this->lateService->index();
        return ResponseHelper::success($result);
    }
    public function store(LateRequest $request)
    {
        $result = $this->lateService->store($request);
        return ResponseHelper::success($result);
    }
    public function update($id, Request $request)
    {
        $result = $this->lateService->update($id, $request);
        return ResponseHelper::success($result);
    }
    public function destroy($id)
    {
        $result = $this->lateService->destroy($id);
        return ResponseHelper::success($result);
    }
    public function show($id)
    {
        $result = $this->lateService->show($id);
        return ResponseHelper::success($result);
    }
}
