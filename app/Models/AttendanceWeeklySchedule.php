<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class AttendanceWeeklySchedule extends Model
{
    protected $fillable = ['employee_id', 'day_of_week', 'category_id'];

    protected $casts = [
        'day_of_week' => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(AttendanceEmployee::class, 'employee_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(AttendanceCategory::class);
    }

    public function getDayOfWeekNameAttribute()
    {
        $weekdays = Carbon::getDays();
        return Carbon::create($weekdays[$this->day_of_week])->locale('nl_NL')->dayName;

    }


}
