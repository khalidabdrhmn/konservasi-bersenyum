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
        'start_date',
        'end_date',
        'is_active',
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
}