<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use View;
use Validator;
use Hash;


class UserController extends Controller
{
    protected function change_password(Request $request){
        if(Auth::guest()){
            abort(403, 'Access forbidden, maybe register first');
        } 

        # grab current user
        $user = Auth::user();

        if($request->isMethod('post')){
            Validator::extend('current_password', function($attribute, $value) use ($user) {
                return Hash::check( $value, $user->password );
            });

            $this->validate($request, [
                'current_password' => 'required|min:6|max:120|current_password:' . Auth::user()->password,
                'password' => 'required|confirmed|min:6|max:120',
            ]);

            $user->password = Hash::make($request->get('password'));
            $user->save();

            $data = [
                'message' => trans('text.password_reset_email_body')
            ];

            EmailController::send_message($data, trans('text.password_reset_email_title') );

            return View::make('message')->with($data);
            
        }

        return View::make('change_password');
    }
}
