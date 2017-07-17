<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $roles = [
            [
                'label' => 'General',
                'code'  => 'general',
            ],
            [
                'label' => 'Trainee',
                'code'  => 'trainee',
            ],
        ];

        $general = Role::create($roles[0]);
        $general->permissions()->sync(Permission::whereCode('general')->pluck('id')->toArray());
        $trainee = Role::create($roles[1]);
        $trainee->permissions()->sync(Permission::pluck('id')->toArray());
    }
}
