<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceCategory extends Model
{
    protected $fillable = ['name'];

    public function scheduleOverrides()
    {
        return $this->hasMany(AttendanceScheduleOverride::class);
    }

    public function weeklySchedules()
    {
        return $this->hasMany(AttendanceWeeklySchedule::class, 'category_id', 'id');
    }

    // Validatie regels voor het vullen van de velden
    public static $rules = [
        'name' => 'required|string|max:255',
    ];

}
