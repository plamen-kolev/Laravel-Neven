<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Slide as Slide;
use View;

class SlideController extends Controller{
    public function index(){
        $slides = Slide::orderBy('id', 'desc')->get();
        $data = [
            'slides' => $slides
        ];
        return View::make('slide.index')->with($data);
    }

    public function create(){
        $slide = new Slide();
        $data = [
            'slide' => $slide,
            'method' => 'post',
            'route' => 'slide.store'
        ];
        return View::make('slide.create_or_edit')->with($data);
    }

    public function store(Request $request){
        $this->validate($request, [
            'image'    => 'required',
        ]);
        $slide = new Slide($request->all() );

        if($request->file('image') && $request->file('image')->isValid()){
            $slide->image = HelperController::upload_image($request->file('image'));
        }
        $slide->save();

        return redirect()->route('slide.index');
    }

    public function edit($id){
        $slide = Slide::where('id', $id)->first();
        if (!$slide){
            return abort(404, "Slide not found");
        };
        $data = [
            'slide' => $slide,
            'route' => 'slide.update',
            'method' => 'put'
        ];
        return View::make('slide.create_or_edit')->with($data);
    }

    public function update(Request $request, $id){
        $slide = Slide::where('id', $id)->first();
        $slide->update( $request->all() );

        if($request->file('image') && $request->file('image')->isValid()){
            $slide->image = HelperController::upload_image($request->file('image'));
        }
        $slide->save();
        return redirect()->route('slide.index');
    }

    public function destroy($id){
        Slide::where('id', $id)->first()->delete();
        return redirect()->route('slide.index');
    }
}
