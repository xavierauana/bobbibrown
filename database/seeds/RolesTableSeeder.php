<?php

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

        foreach ($roles as $index => $role) {
            Role::create($role);
        }
    }
}
