<?php
/*
 * Copyright (c) 2025
 *
 *  @author Juan Manuel Cortéz <juanm.cortez@gmail.com>
 *  @copyright 2025 Nobidium LLC.
 *  @license MIT License
 */

namespace App\Models\Demographics;

use App\Enums\EmailType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Email extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email_type',
        'email',
        'is_primary',
        'is_verified',
        'verified_at',
        'demographic_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'id',
        'is_primary',
        'is_verified',
        'verified_at',
        'demographic_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_type' => EmailType::class,
            'is_primary' => 'boolean',
            'is_verified' => 'boolean',
            'verified_at' => 'datetime:M d, Y H:i',
        ];
    }

    /**
     * Get the demographic that owns this email.
     *
     * @return BelongsTo
     */
    public function demographic(): BelongsTo
    {
        return $this->belongsTo(Demographic::class, 'id', 'demographic_id');
    }

    /**
     * Scope a query to only include primary emails.
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope a query to only include verified emails.
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Mark this email as verified.
     */
    public function markAsVerified(): void
    {
        $this->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);
    }

    /**
     * Set this email as primary and unset others for the same demographic.
     */
    public function setAsPrimary(): void
    {
        // Unset all other primary emails for this demographic
        static::where('demographic_id', $this->demographic_id)
            ->where('id', '!=', $this->id)
            ->update(['is_primary' => false]);

        // Set this as primary
        $this->update(['is_primary' => true]);
    }
}
