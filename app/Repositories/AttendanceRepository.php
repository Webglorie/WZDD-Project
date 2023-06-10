<?php

namespace App\Repositories;

use App\Models\AttendanceWeeklySchedule;
use App\Repositories\Interfaces\AttendanceRepositoryInterface;

class AttendanceRepository implements AttendanceRepositoryInterface
{

    public function getByDayOfWeek($dayOfWeek)
    {
        // Haal alle WeeklySchedules op die overeenkomen met de opgegeven dag van de week
        return AttendanceWeeklySchedule::where('day_of_week', $dayOfWeek)->get();
    }
}
