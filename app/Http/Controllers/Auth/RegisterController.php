<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Http\Request;
use App\Invitations;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'street' => ['required'],
            'house_number' => ['required'],
            'city' => ['required'],
            'post_code' => ['required'],
            'country' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'street' => $data['street'],
            'post_code' => $data['house_number'],
            'house_number' => $data['post_code'],
            'city' => $data['city'],
            'country' => $data['country'],
            'password' => Hash::make($data['password']),
            'api_token' => Str::random(40),
        ]);
    }

    public function redirectTo()
    {
        return app()->getLocale() . '/';
    }

    public function showRegistrationForm(Request $request)
    {
        $invitation_token = $request->get('invitation_token');
        $invitation = Invitations::where('invitation_token', $invitation_token)->firstOrFail();
        $email = $invitation->email;

        return view('auth.register', compact('email'));
    }

    public function registered(Request $request, $user)
    {
        $invitation = Invitations::where('email', $user->email)->firstOrFail();
        $invitation->registered_at = $user->created_at;
        $invitation->user_id = $user->id;
        $invitation->save();
    }
}
