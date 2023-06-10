<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceScheduleOverride extends Model
{
    protected $fillable = ['employee_id', 'date', 'category_id'];

    public function employee()
    {
        return $this->belongsTo(AttendanceEmployee::class);
    }

    public function category()
    {
        return $this->belongsTo(AttendanceCategory::class);
    }
}
