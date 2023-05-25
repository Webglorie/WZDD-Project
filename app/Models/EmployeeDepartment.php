<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class EmployeeDepartment extends Model
{
    protected $fillable = ['name', 'description'];

    public function employees()
    {
        return $this->hasMany(AttendanceEmployee::class);
    }
}
