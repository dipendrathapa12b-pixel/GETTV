<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stream extends Model
{
    protected $fillable = [
        'sport_match_id',
        'name',
        'player_type',
        'stream_url',
        'is_primary',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function sportMatch(): BelongsTo
    {
        return $this->belongsTo(SportMatch::class);
    }
}
