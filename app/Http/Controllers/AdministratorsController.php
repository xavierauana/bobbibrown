<?php

namespace App\Http\Controllers;

use Anacreation\MultiAuth\Model\Admin;
use Anacreation\MultiAuth\Model\AdminRole;
use App\Http\Requests\Admin\UpdateAdminRequest;
use Illuminate\Http\Request;

class AdministratorsController extends Controller
{
    public function index() {
        $this->authorize("view", Admin::class);

        $administrators = Admin::all();

        return view('administrators.index', compact('administrators'));
    }

    public function create() {
        $this->authorize("create", Admin::class);

        $roles = AdminRole::all();

        return view('administrators.create', compact('roles'));
    }

    public function edit(Admin $administrator) {
        $this->authorize("edit", Admin::class);

        $roles = AdminRole::all();

        return view('administrators.edit', compact('roles', 'administrator'));
    }

    public function update(Admin $administrator, UpdateAdminRequest $request) {
        $administrator->name = $request->get("name");
        $administrator->email = $request->get("email");
        $administrator->save();

        return redirect()->route('administrators.index');
    }

    public function destroy(Request $request, Admin $administrator) {
        $this->authorize('delete', Admin::class);

        $administrator->delete();

        if ($request->wantsJson()) {
            return response()->json('completed');
        }

        return redirect()->route('administrators.index');
    }
}
