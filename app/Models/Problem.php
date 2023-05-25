<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    use HasFactory;

    static $rules = [
        'problem_number' => 'required',
        'description' => 'required',
    ];

    protected $fillable = [
        'problem_number',
        'description',
    ];



}
