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

            $data = array(
                'alert_type'    => 'alert-success',
                'alert_text'    => 'Password change successful',
                'message'       => trans('text.password_changed')
            );

            EmailController::send_message($data);

            return View::make('message')->with($data);
            
        }

        return View::make('change_password');
    }
}
