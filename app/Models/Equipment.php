<?php

namespace App\Models;

use App\Enums\EquipmentCondition;
use App\Enums\EquipmentStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'ultimo_id',
        'status',
        'condition',
    ];

    // Definieer de enum-klassen voor de status en conditie van het materiaal
    protected $enums = [
        'status' => EquipmentStatus::class,
        'condition' => EquipmentCondition::class,
    ];

    // Definieer de relatie met het EquipmentCategory-model
    public function category()
    {
        return $this->belongsTo(EquipmentCategory::class);
    }

    // Haal de laatste geleende datum van het materiaal op
    public function lastBorrowedDate()
    {
        $now = Carbon::now();
        $lastBorrowedEquipment = $this->borrowedEquipment()
            ->where('borrowed_date_begin', '<=', $now)
            ->latest()
            ->first();

        if ($lastBorrowedEquipment) {
            return $lastBorrowedEquipment->borrowed_date_begin;
        }

        return null;
    }

    public function borrowedEquipment()
    {
        return $this->hasMany(BorrowedEquipment::class, 'equipment_id');
    }

    // Controleer of het materiaal momenteel is uitgeleend
    public function isBorrowed()
    {
        $now = Carbon::now();

        return $this->borrowedEquipment()
            ->where('borrowed_date_begin', '<=', $now)
            ->where('borrowed_date_end', '>=', $now)
            ->exists();
    }

    // Definieer de relatie met de EquipmentNote-modellen
    public function notes()
    {
        return $this->hasMany(EquipmentNote::class);
    }
}
