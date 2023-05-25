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

    protected $enums = [
        'status' => EquipmentStatus::class,
        'condition' => EquipmentCondition::class,
    ];

    public function category()
    {
        return $this->belongsTo(EquipmentCategory::class);
    }

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
        return $this->hasMany(BorrowedEquipment::class);
    }

    public function isBorrowed()
    {
        $now = Carbon::now();

        return $this->borrowedEquipment()
            ->where('borrowed_date_begin', '<=', $now)
            ->where('borrowed_date_end', '>=', $now)
            ->exists();
    }

    public function notes()
    {
        return $this->hasMany(EquipmentNote::class);
    }

}
