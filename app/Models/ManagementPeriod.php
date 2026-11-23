<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManagementPeriod extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'start_date',
        'end_date',
        'is_active',
        'status',
        'description',
        'user_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi dengan anggota kepengurusan dalam periode ini.
     */
    public function members(): HasMany
    {
        return $this->hasMany(Member::class, 'management_period_id');
    }

    /**
     * Relasi dengan administrator yang membuat periode.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function divisions(): HasMany
    {
        return $this->hasMany(Division::class);
    }

    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }
}