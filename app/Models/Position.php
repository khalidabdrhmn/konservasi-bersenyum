<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    protected $fillable = [
        'management_period_id', 'division_id', 'parent_position_id',
        'name', 'slug', 'description', 'sort_order',
    ];

    public function period(): BelongsTo
    {
        return $this->belongsTo(ManagementPeriod::class, 'management_period_id');
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'parent_position_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(MemberAssignment::class);
    }
}
