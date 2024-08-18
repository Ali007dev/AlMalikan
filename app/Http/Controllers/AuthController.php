<?php
namespace App\Http\Controllers;

use App\Enums\FileStatusEnum;
use App\Enums\RoleEnum;
use App\Helper\ResponseHelper;
use App\Http\Requests\RegisterRequest;
use App\Interfaces\RegisteredUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Rules\UniqueUserBranchRule;
use App\Services\ApiResponseService;
use App\Services\EmployeeService;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    private $employeeService;
    private $userService;

    public function __construct(EmployeeService $employeeService ,UserService $userService)
    {
        $this->employeeService = $employeeService;
        $this->userService = $userService;

        $this->middleware('auth:api', ['except' => ['login','register']]);

    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required_without:phone_number|email',
            'phone_number' => 'required_without:email|string',
            'password' => 'required|string',
        ]);
        if($request->email){
            $credentials = $request->only('email', 'password');
            }
             if($request->phone_number){
            $credentials = $request->only('phone_number', 'password');
            }
        $token = Auth::attempt($credentials);
        if (!$token) {
            return ApiResponseService::errorResponse(
                'unauthorized');
        }

        $user = Auth::user();
        return ApiResponseService::successResponse([
            'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',]]);

    }
    public function processPhoneNumber($request) {
        $phoneNumber = $request->phone_number;

        if (substr($phoneNumber, 0, 1) == '0') {
            $phoneNumber = '+963' . substr($phoneNumber, 1);
        }

        return $phoneNumber;
    }
    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        $phoneNumber = $this->processPhoneNumber($request);

        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'middle_name' => $request->middle_name,
                'phone_number' =>  $phoneNumber,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role'=> $request->role,
                'branch_id'=> $request->branch_id,

            ]);


            $token = Auth::login($user);
            $role=$request->role;

            if ($request->hasFile('image')) {
                $image = upload($request->image, 'users/images');
                $user->profileImage()->create([
                    'image' => $image,
                    'type' => FileStatusEnum::PROFILE
                ]);
            }

            switch ($role){
                case RoleEnum::EMPLOYEE :
                    $this ->employeeService->createEmployee(
                        $user->id,
                        $request->pin,$request->start_date,
                        $request->salary,
                        $request->national_id,
                        $request->description,
                        $request->position,
                        $request->isFixed,
                        $request->ratio,

                    );
                    $this->employeeService->createExperience($request,$user->id);
                    $this->employeeService->addServicesForUser($request->services,$user->id);

                    case RoleEnum::USER:
                        if($request->branches){
                    $this->userService->addBranchesForUser($request->branches,$user->id);
                        }
                    break;
            }

            DB::commit();

            return ApiResponseService::successResponse([
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponseService::errorMsgResponse(
                $e->getMessage());
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

}
