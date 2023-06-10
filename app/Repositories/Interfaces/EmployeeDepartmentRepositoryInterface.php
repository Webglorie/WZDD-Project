<?php

namespace App\Repositories\Interfaces;

use App\Models\EmployeeDepartment;

interface EmployeeDepartmentRepositoryInterface
{
    public function getAll();

    public function getById($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function createNew(): EmployeeDepartment;
}
