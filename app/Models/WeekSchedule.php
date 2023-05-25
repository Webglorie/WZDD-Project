<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class WeekSchedule extends Model
{
    protected $fillable = [
        'employee_id', 'schedule'
    ];

    public function employee()
    {
        return $this->belongsTo(AttendanceEmployee::class, 'employee_id');
    }
    public function attendanceCategories()
    {
        return $this->hasMany(AttendanceCategory::class);
    }
}
