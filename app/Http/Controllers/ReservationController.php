<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\UserReservationResource;
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
        return ApiResponseService::successResponse(ReservationResource::collection($result));
    }

    public function report($id,Request $request)
    {
        $result = $this->reservationService->report($id,$request->date);
        return ApiResponseService::successResponse($result);
    }
    public function archive($id)
    {
        $result = $this->reservationService->archive($id);
        return ApiResponseService::successResponse($result);
    }
    public function recent($id)
    {
        $result = $this->reservationService->recent($id);
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

    public function storeMe(ReservationRequest $request)
    {
        $result = $this->reservationService->storeMe($request);
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

    public function showEmployee($id)
    {
        $result = $this->reservationService->showEmployee($id);
        return ApiResponseService::successResponse($result);
    }
    public function showUser($id)
    {
        $result = $this->reservationService->showUser($id);
        return ApiResponseService::successResponse($result);
    }


    public function userPercentage($id)
    {
        $result = $this->reservationService->userPercentage($id);
        return ApiResponseService::successResponse($result);
    }

    public function archiveWithUser($id)
    {
        $result = $this->reservationService->archiveWithUser($id);
        return ApiResponseService::successResponse($result);
    }

    public function recentWithUser($id)
    {
        $result = $this->reservationService->recentWithUser($id);
        return ApiResponseService::successResponse($result);
    }


    public function archiveMe()
    {
        $result = $this->reservationService->archiveMe();
        return ApiResponseService::successResponse(UserReservationResource::collection($result));
    }

    public function recentMe()
    {
        $result = $this->reservationService->recentMe();
        return ApiResponseService::successResponse(UserReservationResource::collection($result));
    }

    public function decline($id)
    {
        $result = $this->reservationService->decline($id);
        return ApiResponseService::successResponse($result);
    }
    public function accept($id)
    {
        $result = $this->reservationService->accept($id);
        return ApiResponseService::successResponse($result);
    }
}
