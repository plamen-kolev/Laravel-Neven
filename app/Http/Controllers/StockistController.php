<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use View;
use Illuminate\Support\Str as Str;
use App\Stockist as Stockist;

class StockistController extends Controller{
    public function index(){
        $objects = Stockist::all();
        $data = array(
            'stockists'  => $objects,
            'page_title'    => trans('text.stockists_title')
        );
        return View::make('stockist.index')->with($data);
    }

    public function create(){
        $object = new Stockist();
        $data = array(
            'object'  => $object,
            'method' => 'post',
            'route' => 'stockist.store'
        );
        return View::make('stockist.create_or_edit')->with($data);
    }

    public function store(Request $request){
        $object = new Stockist();
        if( $object->validate($request->all()) ){
            $slug = Str::slug($request->get('title'));
            $object->thumbnail = HelperController::upload_image($request->file('thumbnail'));
            $object->title = $request->get('title');
            $object->slug = $slug;
            $object->address = $request->get('address');
            $object->lat = $request->get('lat');
            $object->lng = $request->get('lng');

            $object->save();
            return redirect()->route('stockist.show', $object->slug);
        } else {
            return redirect()->route('stockist.create')
                ->withErrors($object->errors)
                ->withInput();
        }
    }

    public function edit($slug){
        $object = Stockist::where('slug', $slug)->first();
        $data = array(
            'object'  => $object,
            'method' => 'put',
            'route' => 'stockist.update'
        );
        return View::make('stockist.create_or_edit')->with($data);
    }

    public function update(Request $request, $slug){
        $object = Stockist::where('slug', $slug)->first();
        $object->update( $request->all() );

        if($request->get('title')){
            $object->slug = Str::slug($request->get('title'));
        }
        $file = $request->file('thumbnail');
        if($file && $file->isValid()){
            $object->thumbnail = HelperController::upload_image($file);
        }
        $object->save();
        return redirect()->route('stockist.index');
    }

    public function destroy($slug){
        Stockist::where('slug', $slug)->first()->delete();
        return back();
    }

    public function become_stockist(Request $request){
        if ($request->method() == 'POST'){
            $this->validate($request, [
                'first_name'    => 'required|max:255|string',
                'last_name'     => 'required|max:255|string',
                'email'         => 'required|max:255|email',
                'website'       => 'required|max:255|string',
                'company'       => 'required|max:255|string',
                'about_you'     => 'required|max:5000|'

            ]);
            EmailController::send_contact_email( $request->all() );
            $our_response = [
                'alert_text' => 'Thank you !', 
                'alert_type' =>'success',
                'message'    => 'Thank you',
            ];
            return View::make('message', $our_response);
        }
        $data = [
            'page_title'    => trans('text.become_stockist_title')
        ];
        return View::make('stockist.become_form', $data);
    }


}
