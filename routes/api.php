<?php

use App\Http\Controllers\AgendaItemController;
use App\Http\Controllers\BorrowedEquipmentController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProblemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
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

Route::middleware('auth:sanctum')->get('/users', function (Request $request) {
    return $request->user();
});



Route::get('/attendance-categories', [AttendanceController::class, 'getCategories']);
Route::get('/problems', [ProblemController::class, 'getProblems']);
Route::get('/notifications', [NotificationController::class, 'getNotifications']);

Route::post('/attendance-employees', [AttendanceController::class, 'storeEmployee']);
Route::post('/attendances', [AttendanceController::class, 'store']);
Route::get('/attendances', [AttendanceController::class, 'getAttendances']);
Route::get('/attendance-employees-today', [AttendanceController::class, 'getAttendanceToday']);
Route::put('/attendances/{category_id}/{employee_id}', [AttendanceController::class, 'updateCategory']);
Route::delete('/attendance-employees/{attendanceId}', [AttendanceController::class, 'destroy']);

Route::get('borrowed-equipments/{category}', [BorrowedEquipmentController::class, 'getList']);
Route::post('/attendance/{id}/update-schedule', [AttendanceController::class, 'updateSchedule']);
Route::get('/equipment/{categoryId}/available', [EquipmentController::class, 'getAvailableEquipment']);

Route::get('/agenda-items', [AgendaItemController::class, 'getAgendaItems']);

