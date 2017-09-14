<?php

namespace Tests\Feature;

use Anacreation\MultiAuth\Model\Admin;
use Anacreation\MultiAuth\Model\AdminPermission;
use Anacreation\MultiAuth\Model\AdminRole;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminUserApiTest extends TestCase
{

    use DatabaseTransactions;

    public function test_get_admin() {

        $admin = $this->create_new_admin("indexAdmin");

        $this->actingAs($admin, 'admin');

        $response = $this->get('/admin/administrators');
        $response->assertStatus(200);
        $response->assertViewIs("administrators.index");
        $response->assertViewHas("administrators");
    }

    public function test_get_create() {

        $admin = $this->create_new_admin("createAdmin");

        $this->actingAs($admin, 'admin');

        $response = $this->get('/admin/administrators/create');
        $response->assertStatus(200);
        $response->assertViewIs("administrators.create");
        $response->assertViewHas("roles");
    }

    public function test_get_edit() {

        $admin = $this->create_new_admin("editAdmin");

        $this->actingAs($admin, 'admin');

        $response = $this->get("/admin/administrators/{$admin->id}/edit");
        $response->assertStatus(200);
        $response->assertViewIs("administrators.edit");
        $response->assertViewHas(["roles", "administrator"]);
    }


    private function create_new_admin(string $permissionCode): Admin {
        $admin = factory(Admin::class)->create();
        $role = factory(AdminRole::class)->create();
        $permission = AdminPermission::whereCode($permissionCode)->first();

        if (!$permission) {
            $permission = factory(AdminPermission::class)->create([
                'code'  => $permissionCode,
                'label' => "HIHI"
            ]);
        }

        $role->permissions()->save($permission);
        $admin->roles()->save($role);

        return $admin;
    }
}
