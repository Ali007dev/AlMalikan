<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Complaint;
use App\Models\Decicion;
use App\Models\Experince;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Laravel\Scout\Facades\Scout;

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
    public function storeImages($id,Request $request)
    {
        $user = $this->userService->storeImages($id,$request);
        return ResponseHelper::success($user);
    }



    public function search(Request $request)
    {
        $query = $request->input('query');
        $users = User::search($query)->get();
        $educations = Complaint::search($query)->get();
        $articles = Experince::search($query)->get();
        $results = collect()
            ->merge($users)
            ->merge($educations)
            ->merge($articles)
            ->unique('id')
            ->values();

        return response()->json($results);
    }
}
