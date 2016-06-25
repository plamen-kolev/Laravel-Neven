<?php

namespace App\Http\Controllers;
use App\Ingredient as Ingredient;
use View;
use Illuminate\Support\Str as Str;
use Illuminate\Http\Request;

use App\Http\Requests;

class IngredientController extends Controller
{
    public function show($slug){
        $ingredient = Ingredient::where('slug', $slug)->first();
        if(!$ingredient){
            abort(404, "Ingredient $slug was not found");
        }
        return View::make('ingredient.show')->with('ingredient', $ingredient);
    }

    public function create(){
        $ingredient = new Ingredient();
        return View::make('ingredient.create')->with('ingredient', $ingredient);
    }

    public function store(Request $request){
        $this->validate($request, [
            'title_en'          => 'unique:ingredients,title_en|required|max:255',
            'title_nb'          => 'unique:ingredients,title_nb|required|max:255',
            'description_en'    => 'required|max:255',
            'description_nb'    => 'required|max:255',
            'thumbnail'         => 'required|max:10000|mimes:jpeg,jpg,png'
        ]);    

        if ($request->file('thumbnail')->isValid()) {
            
            Ingredient::create([
                'thumbnail'    => HelperController::upload_image( $request->file('thumbnail') ),
                'title_en'  => $request->get('title_en'),
                'title_nb'  => $request->get('title_nb'),

                'description_en' => $request->get('description_en'),
                'description_nb' => $request->get('description_nb'),

                'slug'      =>  Str::slug($request->get('title_en'))
            ]);

            $data = array(
                'alert_type'    => 'alert-success',
                'alert_text'    => 'Ingredient created successfully',
                'message'       => 'Ingredient '. $request->get('title_en') .' successful'
            );
            
            return View::make('message')->with($data);
        }

        return Response('File upload failed', 400);
    }
}
