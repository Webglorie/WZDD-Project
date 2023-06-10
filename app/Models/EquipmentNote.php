<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentNote extends Model
{
    protected $fillable = [
        'equipment_id',
        'content',
    ];

    // Definieer de relatie met het Equipment-model
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    // Methode om het aantal notities voor een specifiek materiaal op te halen
    public static function countNotes($equipmentId)
    {
        return static::where('equipment_id', $equipmentId)->count();
    }
}
