<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run() {
        $permissions = [
            [
                'label' => 'General',
                'code'  => 'general',
            ],

        ];

        foreach ($permissions as $permission) {
            \App\Permission::create($permission);
        }
    }
}

