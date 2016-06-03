<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use View;
use App\Stockist as Stockist;

class StockistController extends Controller
{
    public function create(){
        $stockist = new Stockist();

        $data = array(
            'stockist'  => $stockist
        );

        return View::make('stockist.create')->with($data);
    }

    public function store(Request $request){

        $stockist = new Stockist();
        if($validation = $stockist->validate($request->all())){
            dd("I am valid");
        } else {
            dd($stockist->errors);
        }
    }


}
