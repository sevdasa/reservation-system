<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view dashboard',
            'edit profile',
            'manage users',
            'create appointments',
            'view reports'];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        $roles = [
            'admin' => ['view dashboard', 'edit profile', 'manage users', 'view reports'],
            'doctor' => ['view dashboard', 'create appointments', 'view reports'],
            'user' => ['view dashboard', 'edit profile'],
        ];
        
        foreach ($roles as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($perms);
        }
    }
}
