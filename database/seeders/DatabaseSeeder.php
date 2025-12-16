<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Users\UserSeeder;
use Database\Seeders\Users\RoleSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);

        // ---
        $this->command->info('✓ Everything created!');
        // ---
    }
}
