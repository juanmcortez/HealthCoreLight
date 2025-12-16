<?php

namespace Database\Seeders\Users;

use App\Enums\Gender;
use App\Models\Users\Role;
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
        $new_user = User::where('username', 'superadmin')
            ->first();
        if (!$new_user) {
            $new_user = User::factory()->create([
                'username' => 'superadmin',
                'password' => Hash::make('5uper4dm!nHe4lthC0r3L!ght'),
                'profile_completed' => true,
                'demographic_id' => Demographic::factory()->create([
                    'first_name' => 'Admin',
                    'middle_name' => 'User',
                    'last_name' => 'Super',
                    'date_of_birth' => '1900-01-01',
                    'gender' => Gender::OTHER->value,
                    'ethnicity' => null,
                    'preferred_language' => 'en',
                ])->id,
            ]);
            Email::factory()
                ->primary()
                ->verified()
                ->create([
                    'demographic_id' => $new_user->demographic_id,
                    'email' => 'superadmin@healthcorelight.test',
                ]);
        }
        $new_user->roles()
            ->syncWithoutDetaching(Role::where('slug', 'superadmin')
            ->first());

        // ---
        $this->command->info('✓ Main user created.');
        // ---

        // ------------------------
        $new_user = User::where('username', 'admin')
            ->first();
        if (!$new_user) {
            $new_user = User::factory()->create([
                'username' => 'admin',
                'password' => Hash::make('4dm!nHe4lthC0r3L!ght'),
                'profile_completed' => true,
                'demographic_id' => Demographic::factory()->create([
                    'first_name' => 'User',
                    'middle_name' => null,
                    'last_name' => 'Admin',
                    'date_of_birth' => '1900-01-01',
                    'gender' => Gender::OTHER->value,
                    'ethnicity' => null,
                    'preferred_language' => 'en',
                ])->id,
            ]);
            Email::factory()
                ->primary()
                ->verified()
                ->create([
                    'demographic_id' => $new_user->demographic_id,
                    'email' => 'admin@healthcorelight.test',
                ]);
        }
        $new_user->roles()
            ->syncWithoutDetaching(Role::where('slug', 'admin')
            ->first());


        // ------------------------
        $new_user = User::where('username', 'manager')
            ->first();
        if (!$new_user) {
            $new_user = User::factory()->create([
                'username' => 'manager',
                'password' => Hash::make('m4n4g3rHe4lthC0r3L!ght'),
                'profile_completed' => true,
                'demographic_id' => Demographic::factory()->create([
                    'first_name' => 'User',
                    'middle_name' => null,
                    'last_name' => 'Manager',
                    'date_of_birth' => '1900-01-01',
                    'gender' => Gender::OTHER->value,
                    'ethnicity' => null,
                    'preferred_language' => 'en',
                ])->id,
            ]);
            Email::factory()
                ->primary()
                ->verified()
                ->create([
                    'demographic_id' => $new_user->demographic_id,
                    'email' => 'manager@healthcorelight.test',
                ]);
        }
        $new_user->roles()
            ->syncWithoutDetaching(Role::where('slug', 'manager')
            ->first());

        // ---
        $this->command->info('✓ Secondary users created.');
        // ---

        // ------------------------
        // Create some random users
        // ------------------------
        $count = 12;
        User::factory($count)
            ->create()
            ->each(function ($user) {
                // ---
                $user->update([
                    'is_active' => fake()->boolean(),
                    'profile_completed' => false,
                    'demographic_id' => Demographic::factory()->create()->id,
                ]);

                // Assign random role (excluding superadmin, admin, manager)
                $roles = Role::whereNotIn('slug', ['superadmin', 'admin', 'manager'])->get();
                if ($roles->isNotEmpty()) {
                    $user->roles()->attach($roles->random());
                }

                // ---
                Email::factory()
                    ->primary()
                    ->unverified()
                    ->create([
                        'demographic_id' => $user->demographic_id,
                        // 'email_type' => fake()->randomElement(EmailType::nonPrimary()),
                    ]);
            });
        // ---
        $this->command->info('✓ '.$count.' Random users created.');
        // ---
    }
}
