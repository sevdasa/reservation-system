<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // تعیین گاردهایی که داریم
        $guards = ['web', 'admin', 'bookable'];

        // لیست دسترسی‌ها (permissions)
        $permissions = [
            'view dashboard',
            'edit profile',
            'manage users',
            'create appointments',
            'view reports'
        ];

        // برای هر گارد، دسترسی‌ها رو ایجاد کن
        foreach ($guards as $guard) {
            foreach ($permissions as $permission) {
                Permission::firstOrCreate([
                    'name' => $permission,
                    'guard_name' => $guard,
                ]);
            }
        }

// dd($guards);
        // نقش‌ها به همراه گارد مورد نظرشون
        $roles = [
            'admin' => [
                'guard' => 'admin',
                'permissions' => ['view dashboard', 'edit profile', 'manage users', 'view reports']
            ],
            'doctor' => [
                'guard' => 'bookable',
                'permissions' => ['view dashboard', 'create appointments', 'view reports']
            ],
            'user' => [
                'guard' => 'web',
                'permissions' => ['view dashboard', 'edit profile']
            ]
        ];

        // ساخت نقش و تخصیص دسترسی‌ها
        foreach ($roles as $roleName => $data) {
        //   if($roleName == 'user'){
        //     dd($data);
        //     $role = Role::firstOrCreate([
        //         'name' => $roleName,
        //         'guard_name' => $data['guard'],
        //     ]);
        // }
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => $data['guard'],
            ]);
            $role->syncPermissions($data['permissions']);
        }
    }
}

// $role->givePermissionTo($permission);