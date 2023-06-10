<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeDepartment extends Model
{
    protected $fillable = ['name'];

    public function employees()
    {
        return $this->hasMany(AttendanceEmployee::class);
    }

    // Validatie regels voor het vullen van de velden
    public static $rules = [
        'name' => 'required|string|max:255',
    ];
}
