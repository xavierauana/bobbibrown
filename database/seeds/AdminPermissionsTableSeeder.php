<?php

use Illuminate\Database\Seeder;


class AdminPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run() {

        $actions = [
            "Edit",
            "Show",
            "Index",
            "Delete",
            "Store",
            "Update",
            "Create",
        ];

        $objects = [
            "Test",
            "Menu",
            "Admin",
            "Event",
            "Lesson",
            "Setting",
            "Collection",
            "User",
            "User Role",
            "User Permission",
            "Admin User",
            "Admin Role",
            "Admin Permission",
        ];


        foreach ($objects as $object) {
            foreach ($actions as $action) {
                \Anacreation\MultiAuth\Model\AdminPermission::create([
                    "label" => $action . " " . $object,
                    "code"  => strtolower($action) . str_replace(" ", "", $object)
                ]);
            }
        }
    }
}


