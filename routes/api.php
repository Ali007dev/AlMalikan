<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LateController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\UserController;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('offer')->controller(AdController::class)->group(function () {
    Route::get('index', 'index');
    Route::get('show/{id}', 'show');
    Route::post('store', 'store');
    Route::put('update/{id}', 'update');
    Route::delete('delete/{id}', 'destroy');
});



Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::prefix('employee')->controller(EmployeeController::class)->group(function () {
    Route::get('index/{id}', 'index');
    Route::get('show/{id}', 'show');
    Route::get('attendance-percent/{id}', 'attendancePercent');
});
Route::prefix('branch')->controller(BranchController::class)->group(function () {
    Route::get('index', 'index');
    Route::get('show/{id}', 'show');
    Route::post('store', 'store');
    Route::put('update/{id}', 'update');
    Route::delete('delete/{id}', 'destroy');
    Route::get('get-statistic-for-branch/{id}', 'getStatisticForBranch');
    Route::get('get-digram-statistic-for-branch/{id}', 'getDigramStatisticForBranch');


});
Route::prefix('user')->controller(UserController::class)->group(function () {
    Route::get('index/{id}', 'index');
    Route::get('show/{id}', 'show');
    Route::delete('delete/{id}', 'destroy');
    Route::post('store-images/{id}', 'storeImages');
    Route::get('before-after-images', 'getBeforeAfterImages');
    Route::get('before-after-images-without-paginate', 'getBeforeAfterImageswithoutPaginate');

});

Route::prefix('late')->controller(LateController::class)->group(function () {
    Route::get('index', 'index');
    Route::get('show/{id}', 'show');
    Route::post('store', 'store');
    Route::put('update/{id}', 'update');
    Route::delete('delete/{id}', 'destroy');
});

Route::prefix('attendance')->controller(AttendanceController::class)->group(function () {
    Route::get('user-attendance/{id}', 'getUserAttendance');
     Route::get('get-daily-attendance/{id}', 'getDailyAttendance');
});

Route::prefix('react')->controller(ReactionController::class)->group(function () {
    Route::post('image', 'reactOnImages');
});


Route::prefix('complaint')->controller(ComplaintController::class)->group(function () {
    Route::get('index/{id}', 'index');
    Route::get('show/{id}', 'show');
    Route::post('store', 'store');
    Route::put('update/{id}', 'update');
    Route::delete('delete', 'destroy');
});



Route::prefix('operation')->controller(OperationController::class)->group(function () {
    Route::get('index/{id}', 'index');
    Route::get('show/{id}', 'show');
    Route::post('store', 'store');
    Route::put('update/{id}', 'update');
    Route::delete('delete/{id}', 'destroy');
});





Route::get('/search', [UserController::class, 'search']);
