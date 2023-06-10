<?php

use App\Http\Controllers\AgendaItemController;
use App\Http\Controllers\AttendanceCategoryController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceEmployeeController;
use App\Http\Controllers\AttendanceWeeklyScheduleController;
use App\Http\Controllers\BorrowedEquipmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeDepartmentController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/dashboard');

//Route::get('/dashboard', function () {
//    return view('dashboard.index');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/new', function () {
    return view('new');
})->middleware(['auth', 'verified'])->name('new');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


Route::middleware('auth')->group(function () {
    Route::post('/equipment/{id}/add-note', [EquipmentController::class, 'addNote'])->name('equipment.addNote');
    Route::post('/equipment/{id}/change-condition', [EquipmentController::class, 'changeCondition'])->name('equipment.changeCondition');
    Route::post('/equipment/{id}/change-status', [EquipmentController::class, 'changeStatus'])->name('equipment.changeStatus');


    Route::post('/employees/{employee}/schedules/save', [AttendanceEmployeeController::class, 'saveSchedules'])->name('employees.saveSchedules');

    Route::delete('/attendance-categories/{categoryId}', [AttendanceCategoryController::class, 'destroy'])->name('attendance-categories.destroy');

    Route::put('/schedules/update', [AttendanceWeeklyScheduleController::class, 'updateAllCategories'])->name('schedules.updateAllCategories');

    Route::get('/getjson', [AttendanceController::class, 'getJson'])->name('weekjson');
    Route::post('/menu-items/savemenu', [MenuItemController::class, 'saveMenu'])->name('menu-items.saveMenu');

    Route::resource('equipment', EquipmentController::class);
    Route::resource('menu-items', MenuItemController::class);
    Route::resource('notifications', NotificationController::class);
    Route::resource('agenda-items', AgendaItemController::class);
    Route::resource('problems', ProblemController::class);
    Route::resource('attendance-categories', AttendanceCategoryController::class);
    Route::resource('attendance-employees', AttendanceEmployeeController::class);
    Route::resource('employee-departments', EmployeeDepartmentController::class);
    Route::resource('attendance', AttendanceController::class);
    Route::resource('borrowed-equipments', BorrowedEquipmentController::class);
    Route::resource('users', UserController::class);
    Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');


    Route::delete('/employees/{employee}', [AttendanceEmployeeController::class, 'destroy'])->name('employees.destroy');


    Route::post('/update-weeklyschedules', [AttendanceCategoryController::class, 'updateWeeklySchedules'])->name('attendance-categories.update-weeklyschedules');



    Route::get('/borrowed-equipments/list/{category}', [BorrowedEquipmentController::class, 'showList'])->name('borrowed-equipments.list');

    Route::get('/attendance-overview/', [AttendanceCategoryController::class, 'index'])->name('attendance-categories.index');


    Route::put('/equipment/set-available/{equipment}', [EquipmentController::class, 'setAvailable'])->name('equipment.setAvailable');

    Route::get('/agenda-items/status/{status}', [AgendaItemController::class, 'status'])->name('agenda-items.status');


});


require __DIR__.'/auth.php';
