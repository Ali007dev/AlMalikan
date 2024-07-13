<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $user = $this->userService->index();
        return ResponseHelper::success($user);
    }
}
