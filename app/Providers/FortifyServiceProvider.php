<?php

namespace App\Providers;

use App\Models\Users\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use App\Actions\Fortify\UpdateUserProfileInformation;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registering Views
        Fortify::loginView(static function () {
            return view('auth.login');
        });

        Fortify::registerView(static function () {
            return view('auth.register');
        });

        Fortify::requestPasswordResetLinkView(static function () {
            return view('auth.forgot-password');
        });

        Fortify::resetPasswordView(static function (Request $request) {
            return view('auth.reset-password', ['request' => $request]);
        });

        Fortify::verifyEmailView(static function () {
            return view('auth.verify-email');
        });

        // Override authenticate method
        Fortify::authenticateUsing(static function (Request $request) {
            // Pick only necessary data
            $credentials = $request->only('username', 'password');
            $username = Str::lower(Str::trim($credentials['username']));
            // Find user by username
            $user = User::whereUsername($username)->first();
            // If not found by username, try to find by email through demographics
            if (!$user) {
                $user = User::whereHas('demographics.emails', static function ($query) use ($username) {
                    $query->where('email', $username)
                        ->primary()
                        ->verified();
                })->first();
            }
            // Verify the password
            if ($user && Hash::check($credentials['password'], $user->password)) {
                // Update last login date.
                $user->update(['last_login_at' => now()]);
                //
                return $user;
            }
            // Everything failed
            return null;
        });

        // New user registration conditions
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        // Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', static function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());
            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', static function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
