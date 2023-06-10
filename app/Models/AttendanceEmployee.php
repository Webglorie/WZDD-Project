<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AttendanceEmployee
 *
 * @property $id
 * @property $name
 * @property $department_id
 * @property $created_at
 * @property $updated_at
 *
 * @property AttendanceWeeklySchedule[] $attendanceWeeklySchedules
 * @property EmployeeDepartment $employeeDepartment
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class AttendanceEmployee extends Model
{

    static $rules = [
		'name' => 'required',
		'department_id' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','department_id'];

    public function department()
    {
        return $this->belongsTo(EmployeeDepartment::class);
    }

    public function weeklySchedules()
    {
        return $this->hasMany(AttendanceWeeklySchedule::class, 'employee_id', 'id');
    }

    public function scheduleOverrides()
    {
        return $this->hasMany(AttendanceScheduleOverride::class);
    }

}
