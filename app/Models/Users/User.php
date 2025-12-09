<?php
/*
 * Copyright (c) 2025
 *
 *  @author Juan Manuel Cortéz <juanm.cortez@gmail.com>
 *  @copyright 2025 Nobidium LLC.
 *  @license MIT License
 */

namespace App\Models\Users;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use App\Models\Demographics\Demographic;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\Users\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'uid';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['demographics'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'password',
        'is_active',
        'last_login_at',
        'demographic_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'uid',
        'demographic_id',
        'profile_completed',
        'password',
        'remember_token',
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
            'created_at' => 'datetime:M d, Y H:i',
            'last_login_at' => 'datetime:M d, Y H:i',
            'is_active' => 'boolean',
            'profile_completed' => 'boolean',
            'password' => 'hashed',
        ];
    }

    /**
     * Demographic relationship
     *
     * @return HasOne
     */
    public function demographics(): HasOne
    {
        return $this->hasOne(Demographic::class, 'id', 'demographic_id')->withDefault();
    }
}
