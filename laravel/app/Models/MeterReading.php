<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeterReading extends Model
{
    use HasFactory;

    // กำหนดฟิลด์ที่สามารถเขียนได้
    protected $fillable = [
        'meter_id',
        'voltage',
        'current',
        'power',
        'energy',
        'frequency',
        'power_factor'
    ];
}