<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheetPhoto extends Model
{
    use HasFactory;
    protected $fillable = [
        'checksheet_id',
        'time',
        'photo',
    ];

    public function checksheet()
    {
        return $this->belongsTo(CheckSheet::class);
    }
}
