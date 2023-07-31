<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheet extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'location',
        'descs',
        'reports',
        'validation',
        'created_by',
        'checked_by',
    ];
}
