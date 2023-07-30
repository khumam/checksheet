<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentDescription extends Model
{
    use HasFactory;
    protected $fillable = [
        'equipment_id',
        'desc',
        'satuan',
        'standard'
    ];

    function equipment() {
        return $this->belongsTo(Equipment::class);
    }
}
