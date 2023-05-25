<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentNote extends Model
{
    protected $fillable = [
        'equipment_id',
        'content',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
    public static function countNotes($equipmentId)
    {
        return static::where('equipment_id', $equipmentId)->count();
    }
}
