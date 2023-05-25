<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceEmployee extends Model
{
    protected $fillable = ['name'];

    public function department()
    {
        return $this->belongsTo(EmployeeDepartment::class);
    }

    public function weekSchedule()
    {
        return $this->hasOne(WeekSchedule::class, 'employee_id');
    }

    public function scheduleChanges()
    {
        return $this->hasMany(ScheduleChange::class);
    }
    public function attendanceCategories()
    {
        return $this->hasMany(AttendanceCategory::class);
    }

}
