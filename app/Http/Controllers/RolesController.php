<?php

namespace App\Http\Controllers;

use App\Http\Requests\Roles\StoreRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->authorize('view', Role::class);

        $roles = Role::all();

        return view('roles.index', compact('roles'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->authorize('create', Role::class);

        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request) {
        $role = Role::create([
            'label' => $request->get('label'),
            'code'  => $request->get('code'),
        ]);

        session()->flash('message', "{$role->label} created!");

        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role) {
        $permissions = Permission::all();

        return view("roles.edit", compact("role", "permissions"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Role                $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role) {
        $role->update([
            'label' => $request->get('label')
        ]);

        $request->session()->flash('message', 'Role updated!');

        return redirect()->route("roles.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role) {
        $this->authorize('delete', Role::class);

        $role->delete();

        if (request()->ajax()) {
            return response()->json(['completed' => true]);
        }

        session()->flash('message', "{$role->label} has been deleted!");

        return redirect()->route('roles.index');
    }

    public function showPermissions(Role $role) {

        $this->authorize('edit', Role::class);

        $permissions = Permission::all();

        return view('roles.permissions', compact('permissions', 'role'));
    }

    public function updatePermissions(Request $request, Role $role) {
        $permissionIds = array_map(function ($item) {
            return $item['id'];
        }, $request->all());

        $role->permissions()->sync($permissionIds);

        return response('completed');
    }
}
