<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Http\Controllers\EmailController as EmailController;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
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
            'name'      => 'required|max:255',
            'email'     => 'required|email|max:255|unique:users',
            'password'  => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */

    protected function create(array $data){
        $activation_code = str_random(60);
        EmailController::send_confirmation_email($data['email'], $data['name'], $activation_code);

        return User::create([
            'name'              => $data['name'],
            'email'             => $data['email'],
            'password'          => bcrypt($data['password']),
            'activation_code'   => $activation_code
        ]);

    }

    public function account_activation($activation_code){
        if( ! $activation_code){
            return Response('Missing activation code', 400);
        }
        $user = User::where('activation_code', $activation_code)->first();

        if ( ! $user){
            return Response( trans('text.activate_user_not_found'),400);
        }

        $user->active = 1;
        $user->activation_code = null;
        $user->save();
        return \Response::make( trans('text.activation_successful'), 200);
    }
}
