<?php

namespace App\Repositories\Interfaces;

use App\Models\Equipment;

interface EquipmentRepositoryInterface
{
    public function getAllEquipment();

    public function createEquipment($data);

    public function getEquipmentById($id);

    public function updateEquipment($id, $data);

    public function deleteEquipment($id);

    public function changeStatus(Equipment $equipment, $newStatus);

    public function changeCondition(Equipment $equipment, $newCondition);

    public function createEquipmentNote(Equipment $equipment, $content);

    public function borrowEquipment(Equipment $equipment, $data);

    public function getAvailableEquipment($categoryId);

    public function setEquipmentAvailable(Equipment $equipment);
}
