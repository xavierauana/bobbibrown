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
        $super_admin = Admin::create([
            'name'     => 'Xavier Au',
            'email'    => 'xavier.au@anacreation.com',
            'password' => bcrypt('aukaiyuen')
        ]);
        $super_admin->roles()->save(\Anacreation\MultiAuth\Model\AdminRole::whereCode('super_admin')->first());
        $admin = Admin::create([
            'name'     => 'General Admin',
            'email'    => 'admin@anacreation.com',
            'password' => bcrypt('123456')
        ]);
        $admin->roles()->save(\Anacreation\MultiAuth\Model\AdminRole::whereCode('admin')->first());
    }
}
