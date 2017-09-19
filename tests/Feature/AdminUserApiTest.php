<?php

namespace Tests\Feature;

use Anacreation\MultiAuth\Model\Admin;
use Anacreation\MultiAuth\Model\AdminPermission;
use Anacreation\MultiAuth\Model\AdminRole;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminUserApiTest extends TestCase
{

    use DatabaseMigrations;

    public function test_get_admin() {

        $this->createAndActingAs("indexAdmin");

        $response = $this->get('/admin/administrators');
        $response->assertStatus(200);
        $response->assertViewIs("administrators.index");
        $response->assertViewHas("administrators");
    }

    public function test_get_create() {

        $this->createAndActingAs("createAdmin");

        $response = $this->get('/admin/administrators/create');
        $response->assertStatus(200);
        $response->assertViewIs("administrators.create");
        $response->assertViewHas("roles");
    }

    public function test_get_edit() {

        $admin = $this->createAndActingAs("editAdmin");

        $response = $this->get("/admin/administrators/{$admin->id}/edit");
        $response->assertStatus(200);
        $response->assertViewIs("administrators.edit");
        $response->assertViewHas(["roles", "administrator"]);
    }

    public function test_update_admin() {

        $this->createAndActingAs("updateAdmin");
        $target = $this->create_new_admin("somethingElse");

        $data = [
            'name'  => 'test name',
            'email' => 'abc_testing@abc_testing.com',
        ];
        $response = $this->patch(route('administrators.update', $target->id),
            $data);
        $response->assertRedirect(route("administrators.index"));
        $this->assertDatabaseHas('administrators', [
            'id'    => $target->id,
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public function test_delete_admin() {

        $this->createAndActingAs("deleteAdmin");
        $target = $this->create_new_admin("others");

        $response = $this->delete(route('administrators.destroy', $target->id));
        $response->assertRedirect(route("administrators.index"));

        $this->assertNull(Admin::find($target->id));
    }

    public function test_delete_admin_ajax() {

        $this->createAndActingAs("deleteAdmin");
        $target = $this->create_new_admin("others");

        $response = $this->json("DELETE",
            route('administrators.destroy', $target->id));
        $response->assertStatus(200);

        $this->assertNull(Admin::find($target->id));
    }


    private function createAndActingAs(string $permission): Admin {
        $admin = $this->create_new_admin($permission);
        $this->actingAs($admin, 'admin');

        return $admin;
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
