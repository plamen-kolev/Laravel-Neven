<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Slide as Slide;
use View;

class SlideController extends Controller
{
    public function create(){
        $slide = new Slide();
        return View::make('slide.create')->with('slide', $slide);
    }

    public function store(Request $request){


        $this->validate($request, [
            'image'    => 'required',
        ]);

        Slide::create($request->all() );

        $data = [
            'type'    => 'success',
            'message' => 'Slide successfully created !'
        ];

        return View::make('message')->with($data);
    }
}
