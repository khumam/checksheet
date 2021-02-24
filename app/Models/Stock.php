<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'item_id', 'invoice', 'expired', 'price', 'total'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
