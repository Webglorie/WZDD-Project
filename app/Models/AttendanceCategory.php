<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceCategory extends Model
{
    protected $fillable = ['name'];

    public function schedules()
    {
        return $this->hasMany(WeekSchedule::class);
    }
}
