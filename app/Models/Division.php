<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Division extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'management_period_id',
        'name',
        'slug',
        'description',
        'sort_order',
        'user_id',
    ];

    /**
     * Relasi dengan anggota yang termasuk divisi ini.
     */
    public function members(): HasMany
    {
        return $this->hasMany(Member::class, 'division_id');
    }

    /**
     * Relasi dengan administrator yang membuat divisi.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(ManagementPeriod::class, 'management_period_id');
    }

    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }
}