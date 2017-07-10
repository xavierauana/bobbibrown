<?php

use Anacreation\MultiAuth\Model\AdminPermission;
use Anacreation\MultiAuth\Model\AdminRole;
use Illuminate\Database\Seeder;

class AdminRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $roles = [
            [
                'label' => 'Super Admin',
                'code'  => 'super_admin'
            ],
            [
                'label' => 'Admin',
                'code'  => 'admin'
            ]
        ];

        foreach ($roles as $role) {
            AdminRole::create($role);
        }

        $allPermissions = AdminPermission::all();

        $superAdminRole = AdminRole::whereCode('super_admin')->first();
        $superAdminRole->permissions()->sync($allPermissions->pluck('id')->toArray());

        $adminRole = AdminRole::whereCode('admin')->first();
        $adminRole->permissions()->sync($allPermissions->reject(function (AdminPermission $permission) {
            return strpos($permission->code, 'Admin') > -1;
        })->pluck('id')->toArray());

    }

}
