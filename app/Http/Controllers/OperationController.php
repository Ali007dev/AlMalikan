<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Http\Requests\OperationRequest;
use App\Services\ApiResponseService;
use App\Services\OperationService;
use Illuminate\Http\Request;

class OperationController extends Controller
{
    private $operationService;
    public function __construct(OperationService $operationService)
    {
        $this->operationService = $operationService;
    }

    public function index($id)
    {
        $result = $this->operationService->index($id);
        return ApiResponseService::successResponse($result);
    }
    public function store(OperationRequest $request)
    {
        $result = $this->operationService->store($request);
        return ApiResponseService::successResponse($result);
    }
    public function update($id, Request $request)
    {
        $result = $this->operationService->update($id, $request);
        return ResponseHelper::success($result);
    }
    public function destroy($id)
    {
        $result = $this->operationService->destroy($id);
        return ResponseHelper::success($result);
    }
    public function show($id)
    {
        $result = $this->operationService->show($id);
        return ResponseHelper::success($result);
    }
}
