<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'management_period_id',
        'division_id',
        'name',
        'full_name',
        'display_name',
        'student_id',
        'study_program',
        'university',
        'cohort_year',
        'is_public',
        'position',
        'slug',
        'bio',
        'photo',
        'instagram',
        'linkedin',
        'start_date',
        'end_date',
        'user_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_public' => 'boolean',
        'cohort_year' => 'integer',
    ];

    /**
     * Relasi dengan periode kepengurusan.
     */
    public function period(): BelongsTo
    {
        return $this->belongsTo(ManagementPeriod::class, 'management_period_id');
    }

    /**
     * Relasi dengan divisi tempat anggota bergabung.
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Relasi dengan administrator yang membuat data anggota.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(MemberAssignment::class);
    }
}