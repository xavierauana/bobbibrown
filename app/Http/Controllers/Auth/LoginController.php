<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    protected function attemptLogin(Request $request): bool {
        if ($this->isActiveUser($request)) {
            return $this->guard()->attempt($this->credentials($request), $request->has('remember'));
        }

        return false;
    }

    protected function sendFailedLoginResponse(Request $request) {

        if ($user = User::whereEmail($request->email)->first() and !$user->is_approved) {
            session()->flash('message', 'Please wait for Admin to approve your registration!');

            return redirect()->back();
        }

        $errors = [$this->username() => trans('auth.failed')];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()->withInput($request->only($this->username(), 'remember'))->withErrors($errors);
    }

    private function isActiveUser(Request $request): bool {
        $user = User::whereEmail($request->email)->first();

        return $user and $user->is_approved;
    }
}
