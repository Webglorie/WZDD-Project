<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleChange extends Model
{
    protected $fillable = ['employee_id', 'from_date', 'till_date', 'attendance_category_id'];

    public function employee()
    {
        return $this->belongsTo(AttendanceEmployee::class, 'employee_id');
    }

    public function attendanceCategory()
    {
        return $this->belongsTo(AttendanceCategory::class);
    }
}
