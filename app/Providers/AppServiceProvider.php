<?php

namespace App\Providers;

use App\Models\AgendaItem;
use App\Models\MenuItem;
use App\Observers\AgendaItemCreatorObserver;
use App\Repositories\AgendaItemRepository;
use App\Repositories\AttendanceCategoryRepository;
use App\Repositories\AttendanceEmployeeRepository;
use App\Repositories\AttendanceRepository;
use App\Repositories\AttendanceScheduleOverrideRepository;
use App\Repositories\AttendanceWeeklyScheduleRepository;
use App\Repositories\EmployeeDepartmentRepository;
use App\Repositories\EquipmentRepository;
use App\Repositories\Interfaces\AgendaItemRepositoryInterface;
use App\Repositories\Interfaces\AttendanceCategoryRepositoryInterface;
use App\Repositories\Interfaces\AttendanceEmployeeRepositoryInterface;
use App\Repositories\Interfaces\AttendanceRepositoryInterface;
use App\Repositories\Interfaces\AttendanceScheduleOverrideRepositoryInterface;
use App\Repositories\Interfaces\AttendanceWeeklyScheduleRepositoryInterface;
use App\Repositories\Interfaces\EmployeeDepartmentRepositoryInterface;
use App\Repositories\Interfaces\EquipmentRepositoryInterface;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            EquipmentRepositoryInterface::class,
            EquipmentRepository::class,
        );

        $this->app->bind(
            AgendaItemRepositoryInterface::class,
            AgendaItemRepository::class
        );

        $this->app->bind(
            AttendanceCategoryRepositoryInterface::class,
            AttendanceCategoryRepository::class
        );


        $this->app->bind(
            EmployeeDepartmentRepositoryInterface::class,
            EmployeeDepartmentRepository::class
        );

        $this->app->bind(
            AttendanceEmployeeRepositoryInterface::class,
            AttendanceEmployeeRepository::class);

        $this->app->bind(
                AttendanceWeeklyScheduleRepositoryInterface::class,
                AttendanceWeeklyScheduleRepository::class);

        $this->app->bind(
                AttendanceScheduleOverrideRepositoryInterface::class,
                AttendanceScheduleOverrideRepository::class);

        $this->app->bind(AttendanceRepositoryInterface::class, AttendanceRepository::class);

    }



    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $menu = MenuItem::getNestedMenuItems();
        View::share('menu', $menu);
        AgendaItem::observe(AgendaItemCreatorObserver::class);

    }


}
