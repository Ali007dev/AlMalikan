<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReactionRequest;
use App\Models\Image;
use App\Models\ImageDescription;
use App\Services\ApiResponseService;
use App\Services\ReactionService;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    private $reactionService;
    public function __construct(ReactionService $reactionService)
    {
        $this->reactionService = $reactionService;
    }

    public function reactOnImages(ReactionRequest $image)
    {
        $image = $this->reactionService->react($image);
        return ApiResponseService::successResponse($image);
    }

}
