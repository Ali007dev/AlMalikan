<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Services\ApiResponseService;
use App\Services\ReservationService;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    private $reservationService;
    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }
    public function index($id)
    {
        $result = $this->reservationService->index($id);
        return ApiResponseService::successResponse($result);
    }

    public function me()
    {
        $result = $this->reservationService->me();
        return ApiResponseService::successResponse($result);
    }
    public function store(ReservationRequest $request)
    {
        $result = $this->reservationService->store($request);
        return ApiResponseService::successResponse($result);
    }
    public function update($id, ReservationRequest $request)
    {
        $result = $this->reservationService->update($id, $request);
        return ApiResponseService::successResponse($result);
    }
    public function destroy($id)
    {
        $result = $this->reservationService->destroy($id);
        return ApiResponseService::successResponse($result);
    }
    public function show($id)
    {
        $result = $this->reservationService->show($id);
        return ApiResponseService::successResponse($result);
    }
}
