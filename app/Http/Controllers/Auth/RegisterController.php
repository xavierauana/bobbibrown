<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistration;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('verify');;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
            'name'        => 'required|string|max:255',
            'email'       => 'required|string|email|max:255|unique:users',
            'employee_id' => 'required|string|unique:users,employee_id',
            'password'    => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data) {
        return User::create([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'employee_id' => $data['employee_id'],
            'password'    => bcrypt($data['password']),
        ]);
    }

    public function registered(Request $request, User $user) {

        // Create email token
        $user->email_token = str_random(32);

        $user->save();

        // Assign role to user
        $user->roles()->save(Role::whereCode('general')->first());

        event(new UserRegistration($user));

        auth()->logout();

        session()->flash('message',
            'Thank for registration! A confirmation email will send to you shortly. Please confirm!');

        return redirect($this->redirectPath());
    }

    public function verify(Request $request, string $confirmation_code) {

        $user = User::where([
            'email'       => $request->get('email'),
            'email_token' => $confirmation_code,
        ])->first();

        if ($user) {
            $user->verify();

            $message = "Thank you {$user->name}! Your email is verified!";

        } else {

            $message = 'Sorry, we cannot find your confirmation code!';
        }
        $request->session()->flash('message', $message);

        return redirect($this->redirectPath());
    }

}
