<?php

namespace Database\Seeders\Users;

use App\Models\Users\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'slug' => 'superadmin',
                'name' => 'Super Admin',
                'level' => 100,
                'is_active' => true,
                'description' => 'Full system access',
            ],
            [
                'slug' => 'admin',
                'name' => 'Administrator',
                'level' => 80,
                'is_active' => true,
                'description' => 'System administration',
            ],
            [
                'slug' => 'manager',
                'name' => 'Manager',
                'level' => 60,
                'is_active' => true,
                'description' => 'Department manager',
            ],
            [
                'slug' => 'claims_rep',
                'name' => 'Claims Representative',
                'level' => 50,
                'is_active' => true,
                'description' => 'Claims processing',
            ],
            [
                'slug' => 'biller_rep',
                'name' => 'Biller Representative',
                'level' => 40,
                'is_active' => true,
                'description' => 'Billing operations',
            ],
            [
                'slug' => 'data_entry',
                'name' => 'Data Entry',
                'level' => 30,
                'is_active' => true,
                'description' => 'Data entry operations',
            ],
            [
                'slug' => 'client',
                'name' => 'Client',
                'level' => 10,
                'is_active' => true,
                'description' => 'Standard client access',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}
