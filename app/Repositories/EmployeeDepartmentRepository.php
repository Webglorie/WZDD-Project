<?php

namespace App\Repositories;

use App\Models\EmployeeDepartment;
use App\Repositories\Interfaces\EmployeeDepartmentRepositoryInterface;

class EmployeeDepartmentRepository implements EmployeeDepartmentRepositoryInterface
{
    public function getAll()
    {
        return EmployeeDepartment::all();
    }

    public function getById($id)
    {
        return EmployeeDepartment::findOrFail($id);
    }

    public function create(array $data)
    {
        return EmployeeDepartment::create($data);
    }

    public function createNew(): EmployeeDepartment
    {
        return new EmployeeDepartment();
    }

    public function update($id, array $data)
    {
        $department = EmployeeDepartment::findOrFail($id);
        $department->update($data);
        return $department;
    }

    public function delete($id)
    {
        return EmployeeDepartment::destroy($id);
    }
}
