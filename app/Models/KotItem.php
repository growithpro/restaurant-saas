<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KotItem extends Model
{
    protected $fillable = [
        'kot_id',
        'menu_item_id',
        'item_name',
        'quantity',
        'notes',
        'status',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function kot(): BelongsTo
    {
        return $this->belongsTo(Kot::class);
    }

    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }
}
