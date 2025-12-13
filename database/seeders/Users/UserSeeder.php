<?php

namespace Database\Seeders\Users;

use App\Models\Users\User;
use Illuminate\Database\Seeder;
use App\Models\Demographics\Email;
use Illuminate\Support\Facades\Hash;
use App\Models\Demographics\Demographic;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ------------------------
        // Create the default users
        // ------------------------
        $new_user = User::factory()
            ->create([
                'username' => 'superadmin',
                'password' => Hash::make('5uper4dm!nHe4lthC0r3L!ght'),
                'profile_completed' => false,
                'demographic_id' => Demographic::factory()->create()->id,
            ]);
        Email::factory()
            ->primary()
            ->verified()
            ->create([
                'demographic_id' => $new_user->demographic_id,
                'email' => 'superadmin@healthcorelight.test',
            ]);

        // ------------------------
        $new_user = User::factory()
            ->create([
                'username' => 'admin',
                'password' => Hash::make('4dm!nHe4lthC0r3L!ght'),
                'profile_completed' => false,
                'demographic_id' => Demographic::factory()->create()->id,
            ]);
        Email::factory()
            ->primary()
            ->unverified()
            ->create([
                'demographic_id' => $new_user->demographic_id,
                'email' => 'admin@healthcorelight.test',
            ]);

        // ------------------------
        $new_user = User::factory()
            ->create([
                'username' => 'manager',
                'password' => Hash::make('m4n4g3rHe4lthC0r3L!ght'),
                'profile_completed' => false,
                'demographic_id' => Demographic::factory()->create()->id,
            ]);
        Email::factory()
            ->primary()
            ->unverified()
            ->create([
                'demographic_id' => $new_user->demographic_id,
                'email' => 'manager@healthcorelight.test',
            ]);

        // ------------------------
        // Create some random users
        // ------------------------
        User::factory(7)
            ->create()
            ->each(function ($user) {
                // ---
                $user->update([
                    'is_active' => fake()->boolean(),
                    'profile_completed' => false,
                    'demographic_id' => Demographic::factory()->create()->id,
                ]);
                // ---
                Email::factory()
                    ->primary()
                    ->unverified()
                    ->create([
                        'demographic_id' => $user->demographic_id,
                        // 'email_type' => fake()->randomElement(EmailType::nonPrimary()),
                    ]);
            });
    }
}
