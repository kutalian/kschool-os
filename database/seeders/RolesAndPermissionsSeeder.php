<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $roles = [
            'admin',
            'teacher',
            'student',
            'parent',
            'staff', // Accounting for 'staff' role seen in routes
            'accountant',
            'librarian',
            'receptionist',
            'driver',
            'principal',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Migrate existing users to Spatie roles
        // Assuming the 'role' column references the role name directly
        $users = User::all();
        foreach ($users as $user) {
            if ($user->role && in_array($user->role, $roles)) {
                $user->assignRole($user->role);
            }
        }

        // Example Permissions (Can be expanded later)
        // Permission::create(['name' => 'edit articles']);
    }
}
