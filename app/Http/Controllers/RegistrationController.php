<?php

namespace App\Http\Controllers;
use View;
use App\User;
use Illuminate\Http\Request as Request;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class RegistrationController extends Controller
{
    public function create(){

        return View::make('register');
    }

    public function store(Request $request){

        $this->validate($request, [
            'name' => 'required|unique:users|max:255',
            // 'body' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('register')->withErrors($validator, 'login');
        } else {
            dd("validation passed");
        }

    }
}
