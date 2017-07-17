<?php

use Anacreation\MultiAuth\Model\Admin;
use Illuminate\Database\Seeder;

class AdministratorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $super_admins = [

            [
                'name'     => 'Xavier Au',
                'email'    => 'xavier.au@anacreation.com',
                'password' => bcrypt('aukaiyuen')
            ],
            [
                'name'     => 'Super Admin',
                'email'    => 'super_admin@anacreation.com',
                'password' => bcrypt('123456')
            ]
        ];


        $admins = [
            [
                'name'     => 'General Admin',
                'email'    => 'admin@anacreation.com',
                'password' => bcrypt('123456')
            ]
        ];

        foreach ($super_admins as $super_admin) {
            $super_admin = Admin::create($super_admin);
            $super_admin->roles()->save(\Anacreation\MultiAuth\Model\AdminRole::whereCode('super_admin')->first());
        }

        foreach ($admins as $admin) {
            $admin = Admin::create($admin);
            $admin->roles()->save(\Anacreation\MultiAuth\Model\AdminRole::whereCode('admin')->first());
        }
        
    }
}
