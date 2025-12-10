<?php
/*
 * Copyright (c) 2025
 *
 *  @author Juan Manuel Cortéz <juanm.cortez@gmail.com>
 *  @copyright 2025 Nobidium LLC.
 *  @license MIT License
 */

namespace App\Models\Users;

use Illuminate\Notifications\Notifiable;
use App\Models\Demographics\Demographic;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
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
     * Get the email attribute
     */
    public function getEmailAttribute()
    {
        return $this->demographics?->emails()
            ->where('is_primary', true)
            ->first()
            ?->email;
    }

    /**
     * Determine if the user has verified their email address.
     */
    public function hasVerifiedEmail()
    {
        return $this->demographics?->primary_email?->is_verified ?? false;
    }

    /**
     * Mark the given user's email as verified.
     */
    public function markEmailAsVerified()
    {
        $primaryEmail = $this->demographics?->primary_email;

        if ($primaryEmail) {
            $primaryEmail->markAsVerified();
        }

        return true;
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * Get the email address that should be used for verification.
     */
    public function getEmailForVerification()
    {
        return $this->email; // Uses the accessor we created earlier
    }

    /**
     *  Helper function for the password reset notification
     *
     * @param $token
     * @return void
     */
    public function sendPasswordResetNotification($token): void
    {
        $email = $this->email;
        $this->notify(new ResetPassword($token));
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
