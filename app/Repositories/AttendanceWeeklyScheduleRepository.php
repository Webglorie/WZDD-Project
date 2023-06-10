<?php

namespace App\Repositories;

use App\Models\AttendanceWeeklySchedule;
use App\Repositories\Interfaces\AttendanceWeeklyScheduleRepositoryInterface;

class AttendanceWeeklyScheduleRepository implements AttendanceWeeklyScheduleRepositoryInterface
{
    public function getAll()
    {
        return AttendanceWeeklySchedule::all();
    }

    public function getById($id)
    {
        return AttendanceWeeklySchedule::findOrFail($id);
    }

    public function create(array $data)
    {
        return AttendanceWeeklySchedule::create($data);
    }

    public function update($id, array $data)
    {
        $schedule = AttendanceWeeklySchedule::findOrFail($id);
        $schedule->update($data);
        return $schedule;
    }

    public function delete($id)
    {
        return AttendanceWeeklySchedule::destroy($id);
    }

    public function updateAllCategory($categoryId)
    {
        // TODO: Implement updateAllCategory() method.
    }
}
