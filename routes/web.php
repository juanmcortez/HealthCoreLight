<?php

use App\Models\Users\User;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return User::all();
});
