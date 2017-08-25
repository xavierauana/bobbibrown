<?php

use Illuminate\Database\Seeder;

class CategoryLineProductPermissionsSeeder extends Seeder
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
            "Resource",
            "Category",
            "Line",
            "Product",
        ];

        $superAdminRole = \Anacreation\MultiAuth\Model\AdminRole::whereCode("super_admin")->first();

        foreach ($objects as $object) {
            foreach ($actions as $action) {
                $newPermission = \Anacreation\MultiAuth\Model\AdminPermission::create([
                    "label" => $action . " " . $object,
                    "code"  => strtolower($action) . str_replace(" ", "", $object)
                ]);

                $superAdminRole->permissions()->attach($newPermission);
            }
        }
    }
}
