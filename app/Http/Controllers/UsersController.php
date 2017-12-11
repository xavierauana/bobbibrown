<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->authorize('view', User::class);
        $users = User::all();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) {
        $this->authorize('show', User::class);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user) {
        $user->update([
            'name'        => $request->get('name'),
            'email'       => $request->get('email'),
            'employee_id' => $request->get('employee_id'),
        ]);

        $role_ids = $request->get('role_ids');
        $role_ids = is_array($role_ids) ? $role_ids : [$role_ids];

        $user->roles()->sync($role_ids);

        session()->flash('message', "{$user->name} has been updated");

        return redirect()->route('users.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) {
        $this->authorize('delete', User::class);
        session()->flash('message', "{$user->name} has been deleted");
        $user->delete();

        return redirect()->route('users.index');
    }

    public function restore($userId, User $userRepo) {
        if ($user = $userRepo->onlyTrashed()->find($userId)) {
            $user->restore();

            return redirect()->route('users.index')
                             ->withMessage($user->name . " has been restored!");
        };

        return redirectback()->withMessage('User is invalid!');

    }

    public function showDeletedUsers(User $userRepo) {
        $deletedUsers = $userRepo->onlyTrashed()->get();

        return view('users.trashed', compact('deletedUsers'));
    }

    public function approve(User $user) {
        $this->authorize('edit', User::class);

        $user->is_approved = true;
        $user->save();

        return response('completed');
    }
}
