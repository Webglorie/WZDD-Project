<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowedEquipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'borrowed_date_begin',
        'borrowed_date_end',
        'borrower',
        'ultimo_ticket_number',
    ];

    // Validatie regels voor het vullen van de velden
    public static $rules = [
        'equipment_id' => 'required',
        'borrowed_date_begin' => 'required|date_format:Y-m-d H:i',
        'borrowed_date_end' => 'required|date_format:Y-m-d H:i',
        'borrower' => 'required',
        'ultimo_ticket_number' => 'required',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }
}
