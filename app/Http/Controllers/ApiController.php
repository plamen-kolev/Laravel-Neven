<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Ingredient as Ingredient;
use View;
class ApiController extends Controller
{
    public function get_ingredient($slug){
        $ingredient = Ingredient::where('slug', $slug)->first();
        if(!$ingredient){
            return \Response::make("Ingredient $slug was not found", 404);
        }
        return View::make('ingredient')->with('ingredient', $ingredient);
    }
}
