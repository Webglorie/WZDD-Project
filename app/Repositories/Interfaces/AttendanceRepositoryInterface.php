<?php

namespace App\Repositories\Interfaces;

interface AttendanceRepositoryInterface
{
    public function getByDayOfWeek($dayOfWeek);
}
