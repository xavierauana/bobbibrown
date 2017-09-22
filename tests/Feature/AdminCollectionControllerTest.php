<?php

namespace Tests\Feature;

use Anacreation\Etvtest\Models\Test;
use Anacreation\MultiAuth\Model\Admin;
use Anacreation\MultiAuth\Model\AdminPermission;
use Anacreation\MultiAuth\Model\AdminRole;
use App\Collection;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery;
use Tests\TestCase;

class AdminCollectionControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp() {
        parent::setUp();

        $this->admin = factory(Admin::class)->create();

        $this->collectionMock = Mockery::mock(Collection::class);

        $this->app->instance(Collection::class, $this->collectionMock);
    }

    public function test_collection_index() {

        $role = $this->createRoleWithPermissionCodes(['indexCollection']);
        $this->admin->roles()->save($role);

        $this->actingAs($this->admin, 'admin');

        $this->collectionMock->shouldReceive('all')->once()
                             ->andReturn(new Collection());

        $response = $this->get(route("collections.index"));

        $response->assertStatus(200);
    }

    public function test_collection_index_return_view() {

        $role = $this->createRoleWithPermissionCodes(['indexCollection']);
        $this->admin->roles()->save($role);

        $this->actingAs($this->admin, 'admin');

        $this->collectionMock->shouldReceive('all')->once()
                             ->andReturn(new Collection());

        $response = $this->get(route("collections.index"));

        $response->assertViewIs('collections.index');
    }

    public function test_collection_index_return_view_with_collections() {

        $role = $this->createRoleWithPermissionCodes(['indexCollection']);

        $this->admin->roles()->save($role);

        $this->actingAs($this->admin, 'admin');

        $this->collectionMock->shouldReceive('all')->once()
                             ->andReturn(new Collection());

        $response = $this->get(route("collections.index"));

        $response->assertViewHas('collections');
    }



    private function createRoleWithPermissionCodes(array $permissionCodes
    ): AdminRole {
        $role = factory(AdminRole::class)->create();
        foreach ($permissionCodes as $code) {
            $role->permissions()->save(factory(AdminPermission::class)->create([
                'code' => $code
            ]));
        }

        return $role;
    }
}
