<?php
/*
 * Copyright (c) 2025
 *
 *  @author Juan Manuel Cortéz <juanm.cortez@gmail.com>
 *  @copyright 2025 Nobidium LLC.
 *  @license MIT License
 */

namespace App\Actions\Auth;

use Illuminate\Auth\EloquentUserProvider;

class DemographicsUserProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials) ||
            (count($credentials) === 1 && array_key_exists('password', $credentials))) {
            return false;
        }

        // If email is in credentials, find user through demographics->emails relationship
        if (isset($credentials['email'])) {
            $email = $credentials['email'];

            return $this->createModel()->newQuery()
                ->whereHas('demographics.primary_email', function ($query) use ($email) {
                    $query->where('email', $email);
                })
                ->first();
        }

        // For other credentials, use the parent method
        return parent::retrieveByCredentials($credentials);
    }
}
