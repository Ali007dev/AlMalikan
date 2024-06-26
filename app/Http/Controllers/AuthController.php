<?php
namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Helper\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    private $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
        $this->middleware('auth:api', ['except' => ['login','register']]);

    }


    public function login(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('phone_number', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
           return ResponseHelper::error('unauthorized');
        }

        $user = Auth::user();
        return ResponseHelper::success([
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',]]);

    }

    public function register(Request $request)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'role'=> $request->role,
            ]);

            $token = Auth::login($user);

            $role=$request->role;
            switch ($role){
                case RoleEnum::EMPLOYEE :
                    $this ->employeeService->createEmployee(
                        $user->id,
                        $request->pin,$request->start_date,
                        $request->salary,
                        $request->national_id,
                        $request->description
                    );
                    $this->employeeService->createExperience($request,$user->id);
                    break;
            }

            DB::commit();

            return ResponseHelper::success([
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::error($e->getMessage());
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
