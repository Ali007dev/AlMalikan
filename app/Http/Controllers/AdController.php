<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdsRequest;
use App\Services\AdsService;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;

class AdController extends Controller
{
    private $adService;
    public function __construct(AdsService $adService)
    {
        $this->adService = $adService;
    }

    public function index()
    {
        $result = $this->adService->index();
        return ApiResponseService::successResponse($result);
    }
    public function store(AdsRequest $request)
    {
        $result = $this->adService->store($request);
        return ApiResponseService::successResponse($result);
    }
    public function update($id, AdsRequest $request)
    {
        $result = $this->adService->update($id, $request);
        return ApiResponseService::successResponse($result);
    }
    public function destroy($id)
    {
        $result = $this->adService->destroy($id);
        return ApiResponseService::successResponse($result);
    }
    public function show($id)
    {
        $result = $this->adService->show($id);
        return ApiResponseService::successResponse($result);
    }
}
