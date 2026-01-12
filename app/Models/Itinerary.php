<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Itinerary extends Model
{
    protected $fillable = [
        'trip_id',
        'date',
        'time',
        'title',
        'note',
        'cost',
        'display_order',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    /**
     * 時間から時間帯を自動判定
     */
    public function getTimeSlotAttribute(): string
    {
        if (empty($this->time)) {
            return 'Other';
        }

        // HH:MM 形式から時間部分を取得
        $hour = (int) substr($this->time, 0, 2);

        if ($hour >= 5 && $hour < 12) {
            return 'Morning';
        } elseif ($hour >= 12 && $hour < 17) {
            return 'Afternoon';
        } elseif ($hour >= 17 && $hour < 22) {
            return 'Evening';
        } else {
            return 'Night';
        }
    }

    /**
     * 時間帯の表示順序
     */
    public function getTimeSlotOrderAttribute(): int
    {
        return match($this->time_slot) {
            'Morning' => 1,
            'Afternoon' => 2,
            'Evening' => 3,
            'Night' => 4,
            'Other' => 5,
            default => 6,
        };
    }
}