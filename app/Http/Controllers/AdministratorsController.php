<?php

namespace App\Http\Controllers;

use Anacreation\MultiAuth\Model\Admin;
use Anacreation\MultiAuth\Model\AdminRole;

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
        $this->authorize("editAdmin", Admin::class);

        $roles = AdminRole::all();

        return view('administrators.edit', compact('roles', 'administrator'));
    }
}
