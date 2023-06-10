<?php

namespace App\Repositories;

use App\Models\AttendanceCategory;
use App\Models\AttendanceEmployee;
use App\Repositories\Interfaces\AttendanceCategoryRepositoryInterface;
use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;

class AttendanceCategoryRepository implements AttendanceCategoryRepositoryInterface
{
    public function getAll()
    {
        return AttendanceCategory::all();
    }

    public function find($id)
    {
        return AttendanceCategory::findOrFail($id);
    }

    public function create(array $data)
    {
        return AttendanceCategory::create($data);
    }

    public function update($id, array $data)
    {
        $category = AttendanceCategory::findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function delete($id)
    {
        return AttendanceCategory::destroy($id);
    }

    public function getAllWithSchedulesAndEmployees()
    {
        $currentDayOfWeek = Carbon::now()->isWeekend() ? CarbonInterface::MONDAY : Carbon::today()->dayOfWeek;


        return AttendanceCategory::with(['weeklySchedules' => function ($query) use ($currentDayOfWeek) {
            $query->where('day_of_week', '=', $currentDayOfWeek);
        }, 'weeklySchedules.employee'])->get();
    }

    public function getAllEmployees()
    {
        return AttendanceEmployee::with(['weeklySchedules.category'])->get();
    }

    public function createNew(): AttendanceCategory
    {
        return new AttendanceCategory();
    }
}
