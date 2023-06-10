<?php
namespace App\Repositories;

use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Repositories\Interfaces\EquipmentRepositoryInterface;

class EquipmentRepository implements EquipmentRepositoryInterface
{
    public function getAllEquipment()
    {
        return Equipment::paginate();
    }

    public function createEquipment($data)
    {
        return Equipment::create($data);
    }

    public function getEquipmentById($id)
    {
        return Equipment::findOrFail($id);
    }

    public function updateEquipment($id, $data)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->update($data);
        return $equipment;
    }

    public function deleteEquipment($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();
    }

    public function changeStatus(Equipment $equipment, $newStatus)
    {
        $equipment->status = $newStatus;
        $equipment->save();
    }

    public function changeCondition(Equipment $equipment, $newCondition)
    {
        $equipment->condition = $newCondition;
        $equipment->save();
    }

    public function createEquipmentNote(Equipment $equipment, $content)
    {
        return $equipment->notes()->create(['content' => $content]);
    }

    public function borrowEquipment(Equipment $equipment, $data)
    {
        return $equipment->borrowedEquipment()->create($data);
    }

    public function getAvailableEquipment($categoryId)
    {
        return Equipment::where('category_id', $categoryId)
            ->where('status', 'Inzetbaar')
            ->get();
    }

    public function setEquipmentAvailable(Equipment $equipment)
    {
        $equipment->status = 'Inzetbaar';
        $equipment->save();

        $equipment->borrowedEquipment()->delete();
    }
}
