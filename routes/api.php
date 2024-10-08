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
use App\Http\Controllers\ReservationController;
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
    Route::get('report/{id}', 'report');
    Route::get('reportAll/{id}', 'reportAll');

    Route::get('show/{id}', 'show');
    Route::get('attendance-percent/{id}', 'attendancePercent');
    Route::put('update/{id}', 'update');

});
Route::prefix('branch')->controller(BranchController::class)->group(function () {
    Route::get('index', 'index');
    Route::get('show/{id}', 'show');
    Route::post('store', 'store');
    Route::put('update/{id}', 'update');
    Route::delete('delete/{id}', 'destroy');
    Route::get('get-statistic-for-branch/{id}', 'getStatisticForBranch');
    Route::get('get-digram-statistic-for-branch/{id}', 'getDigramStatisticForBranch');
    Route::get('all/{id}', 'All');


});
Route::prefix('user')->controller(UserController::class)->group(function () {
    Route::get('index/{id}', 'index');

    Route::get('show/{id}', 'show');
    Route::put('update/{id}', 'update');
    Route::put('updateMe', 'updateMe');


    Route::get('showMe', 'me');
    Route::delete('delete/{id}', 'destroy');
    Route::post('store-images/{id}', 'storeImages');
    Route::post('add-branches/{id}', 'addBranchesForUser');



    Route::get('before-after-images/{id}', 'getBeforeAfterImages');
    Route::delete('delete-before-after-images/{id}', 'deleteBeforeAfterImages');

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
     Route::post('file', 'file');


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
    Route::post('create-discount/{id}', 'createDiscount');

    Route::get('available-time/{id}', 'availableTime');

});

Route::prefix('booking')->controller(ReservationController::class)->group(function () {

    Route::get('index/{id}', 'index');
    Route::get('indexMe', 'me');
    Route::get('show/{id}', 'show');
    Route::post('store', 'store');
    Route::post('store-me', 'storeMe');
    Route::put('update/{id}', 'update');
    Route::put('decline/{id}', 'decline');
    Route::put('accept/{id}', 'accept');
    Route::delete('delete/{id}', 'destroy');
    Route::get('user-percentage/{id}', 'userPercentage');
    Route::get('show-user/{id}', 'showUser');
    Route::get('show-employee/{id}', 'showEmployee');
    Route::get('recent-with-user/{id}', 'recentWithUser');
    Route::get('archive-with-user/{id}', 'archiveWithUser');
    Route::get('recent-me', 'recentMe');
    Route::get('archive-me', 'archiveMe');
    Route::get('archive/{id}', 'archive');
    Route::get('recent/{id}', 'recent');
    Route::get('report/{id}', 'report');

});




Route::get('/search', [UserController::class, 'search']);
