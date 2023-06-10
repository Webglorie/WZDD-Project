<?php

use App\Http\Controllers\AgendaItemController;
use App\Http\Controllers\AttendanceCategoryController;
use App\Http\Controllers\AttendanceEmployeeController;
use App\Http\Controllers\AttendanceWeeklyScheduleController;
use App\Http\Controllers\BorrowedEquipmentController;
use App\Http\Controllers\EmployeeDepartmentController;
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




Route::get('/problems', [ProblemController::class, 'getProblems']);
Route::get('/notifications', [NotificationController::class, 'getNotifications']);
Route::get('/attendance-schedules', [AttendanceController::class, 'index']);

Route::put('/weekly-schedules/category/{category_id}', [AttendanceWeeklyScheduleController::class, 'updateAllCategories']);




Route::post('/attendance-employees', [AttendanceController::class, 'storeEmployee']);
Route::post('/attendances', [AttendanceController::class, 'store']);
Route::put('/attendance/update-category/{attendanceId}/{categoryId}', [AttendanceCategoryController::class, 'updateCategory']);

Route::put('/attendance/update-category/{dayOfWeek}/{attendanceId}/{categoryId}', [AttendanceWeeklyScheduleController::class, 'updateCategory']);
Route::post('/attendance/employees', [AttendanceEmployeeController::class, 'newEmployeeApi']);
Route::get('/employee/departments', [EmployeeDepartmentController::class, 'getDepartmentsApi']);
Route::post('/attendance/employees/{employeeId}/weekly-schedules', [AttendanceWeeklyScheduleController::class, 'createWeeklySchedules']);



Route::get('/attendance-employees-today', [AttendanceController::class, 'getAttendanceToday']);
Route::get('/attendancetoday', [AttendanceController::class, 'getAttendanceToday']);
Route::put('/attendances/{category_id}/{employee_id}', [AttendanceController::class, 'updateCategory']);
Route::delete('/attendance-employees/{attendanceId}', [AttendanceController::class, 'destroy']);

Route::get('borrowed-equipments/{category}', [BorrowedEquipmentController::class, 'getList']);
Route::post('/attendance/{id}/update-schedule', [AttendanceController::class, 'updateSchedule']);
Route::get('/equipment/{categoryId}/available', [EquipmentController::class, 'getAvailableEquipment']);

Route::get('/agenda-items', [AgendaItemController::class, 'getAgendaItems']);

