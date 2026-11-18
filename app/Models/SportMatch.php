<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SportMatch extends Model
{
    protected $fillable = [
        'sport_type',
        'custom_sport_name',
        'title',
        'competition',
        'home_team',
        'home_team_logo',
        'away_team',
        'away_team_logo',
         'background_image',
        'match_date',
        'match_time',
        'status',
        'is_featured',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'match_date' => 'date',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function streams(): HasMany
    {
        return $this->hasMany(Stream::class)->orderBy('sort_order');
    }

    public function primaryStream(): HasOne
    {
        return $this->hasOne(Stream::class)
            ->where('is_primary', true);
    }
}
