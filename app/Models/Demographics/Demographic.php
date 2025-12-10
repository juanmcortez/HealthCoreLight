<?php
/*
 * Copyright (c) 2025
 *
 *  @author Juan Manuel Cortéz <juanm.cortez@gmail.com>
 *  @copyright 2025 Nobidium LLC.
 *  @license MIT License
 */

namespace App\Models\Demographics;

use App\Enums\Gender;
use App\Enums\Ethnicity;
use App\Models\Users\User;
use Illuminate\Support\Str;
use App\Enums\PreferredLanguage;
use App\Enums\IdentificationType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Demographic extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['primary_email'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender',
        'identification_number',
        'identification_type',
        'ethnicity',
        'preferred_language',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'id',
        'identification_number',
        'identification_type',
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
            'date_of_birth' => 'date:M d, Y',
            'gender' => Gender::class,
            'identification_type' => IdentificationType::class,
            'ethnicity' => Ethnicity::class,
            'preferred_language' => PreferredLanguage::class,
        ];
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'full_name',
        'id_card',
        'initials',
    ];

    /**
     * Get the full_name attribute.
     */
    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->last_name.', '.$this->first_name.(($this->middle_name) ? ' '.$this->middle_name : null),
        );
    }

    /**
     * Get the id_card attribute.
     */
    public function idCard(): Attribute
    {
        return Attribute::make(
            get: fn() => ($this->identification_number) ? $this->identification_type->label().' #'.$this->identification_number : null,
        );
    }

    /**
     * Get the full_name attribute.
     */
    public function initials(): Attribute
    {
        return Attribute::make(
            get: fn() => Str::upper(Str::substr($this->last_name, 0, 1).Str::substr($this->first_name, 0, 1)),
        );
    }

    /**
     * Get the user relationship if exists.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'demographic_id', 'id')->withDefault();
    }

    /**
     * Get the full list of emails.
     *
     * @return HasMany
     */
    public function emails(): HasMany
    {
        return $this->hasMany(Email::class, 'demographic_id', 'id');
    }

    /**
     * Get the first primary email for the demographics
     *
     * @return HasOne
     */
    public function primary_email(): HasOne
    {
        return $this->hasOne(Email::class, 'demographic_id', 'id')
            ->primary()
            ->withDefault();
    }
}
