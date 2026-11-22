<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'event_date',
        'status',
        'published_at',
        'sort_order',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'published_at' => 'datetime',
            'sort_order' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
