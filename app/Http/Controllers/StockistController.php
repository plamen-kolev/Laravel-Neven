<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use View;
use App\Stockist as Stockist;

class StockistController extends Controller
{

    public function index(){
        $stockists = Stockist::all();

        $data = array(
            'stockists'  => $stockists
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

    public function store(Request $request){

        $stockist = new Stockist();
        if( $stockist->validate($request->all()) ){
            $slug = Str::slug($request->get('title'));
            $stockist->thumbnail_full = HelperController::upload_image($request->get('thumbnail'), 'stockists', $slug);
            $stockist->title = $request->get('title');
            $stockist->slug = $slug;
            $stockist->x = $request->get('x');
            $stockist->y = $request->get('y');

            $stockist->save();
            return "Done";
        } else {
            return redirect()->route('stockist.create')
                ->withErrors($stockist->errors)
                ->withInput();
        }
        
    }


}
