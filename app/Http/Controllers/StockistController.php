<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use View;
use Illuminate\Support\Str as Str;
use App\Stockist as Stockist;

class StockistController extends Controller
{

    public function index(){
        $stockists = Stockist::all();

        $data = array(
            'stockists'  => $stockists,
            'page_title'    => ' - ' . trans('text.stockists')
        );

        return View::make('stockist.index')->with($data);
    }

    public function create(){
        $stockist = new Stockist();

        $data = array(
            'stockist'  => $stockist
        );

        return View::make('stockist.create')->with($data);
    }

    public function destroy($slug){
        Stockist::where('slug', $slug)->first()->delete();
        return back();
    }

    public function store(Request $request){
        $stockist = new Stockist();
        if( $stockist->validate($request->all()) ){
            $slug = Str::slug($request->get('title'));
            $stockist->thumbnail = HelperController::upload_image($request->file('thumbnail'));
            $stockist->title = $request->get('title');
            $stockist->slug = $slug;
            $stockist->address = $request->get('address');
            $stockist->lat = $request->get('lat');
            $stockist->lng = $request->get('lng');

            $stockist->save();
            return "Done";
        } else {
            return redirect()->route('stockist.create')
                ->withErrors($stockist->errors)
                ->withInput();
        }
        
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
            'page_title'    => ' - ' . trans('text.become_stockist')
        ];

        return View::make('stockist.become_form', $data);
    }


}
