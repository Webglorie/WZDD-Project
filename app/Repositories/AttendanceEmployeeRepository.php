<?php

namespace App\Repositories;

use App\Models\AttendanceEmployee;
use App\Repositories\Interfaces\AttendanceEmployeeRepositoryInterface;

class AttendanceEmployeeRepository implements AttendanceEmployeeRepositoryInterface
{
    public function getAll()
    {
        return AttendanceEmployee::all();
    }

    public function getById($id)
    {
        return AttendanceEmployee::findOrFail($id);
    }

    public function create(array $data)
    {
        return AttendanceEmployee::create($data);
    }

    public function update($id, array $data)
    {
        $employee = AttendanceEmployee::findOrFail($id);
        $employee->update($data);
        return $employee;
    }

    public function delete($id)
    {
        return AttendanceEmployee::destroy($id);
    }
}
