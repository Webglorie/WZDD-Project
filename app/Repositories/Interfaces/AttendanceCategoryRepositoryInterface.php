<?php

namespace App\Repositories\Interfaces;

use App\Models\AttendanceCategory;

interface AttendanceCategoryRepositoryInterface
{
    public function getAll();

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function getAllWithSchedulesAndEmployees();

    public function getAllEmployees();

    public function createNew(): AttendanceCategory;


}
