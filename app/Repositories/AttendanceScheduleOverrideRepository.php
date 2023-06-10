<?php

namespace App\Repositories;

use App\Models\AttendanceScheduleOverride;
use App\Repositories\Interfaces\AttendanceScheduleOverrideRepositoryInterface;

class AttendanceScheduleOverrideRepository implements AttendanceScheduleOverrideRepositoryInterface
{
    public function getAll()
    {
        return AttendanceScheduleOverride::all();
    }

    public function getById($id)
    {
        return AttendanceScheduleOverride::findOrFail($id);
    }

    public function create(array $data)
    {
        return AttendanceScheduleOverride::create($data);
    }

    public function update($id, array $data)
    {
        $override = AttendanceScheduleOverride::findOrFail($id);
        $override->update($data);
        return $override;
    }

    public function delete($id)
    {
        return AttendanceScheduleOverride::destroy($id);
    }
}
