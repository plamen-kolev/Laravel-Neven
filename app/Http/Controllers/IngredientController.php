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
            'title_en'          => 'unique:ingredient_translations,title|required|max:255',
            'title_nb'          => 'unique:ingredient_translations,title|required|max:255',
            'description_en'    => 'required|max:255',
            'description_nb'    => 'required|max:255',
            'thumbnail'         => 'required|max:10000|mimes:jpeg,jpg,png'
        ]);    

        if ($request->file('thumbnail')->isValid()) {
            

            $paths = HelperController::crop_image(
                $request->file('thumbnail'), 
                'ingredients', 
                $request->input('title_en'), 
                array(env('MEDIUM_THUMBNAIL'), 
                env('SMALL_THUMBNAIL'))
            );
            
            $ingredient = new Ingredient([
                'thumbnail_full'    => $paths[0],
                'thumbnail_medium'  => $paths[1],
                'thumbnail_small'   => $paths[2],
                'slug'      =>  Str::slug($request->get('title_en'))
            ]);

            $ingredient->save();
            
            $ingredient->translateOrNew('en')->title          = $request->get('title_en');
            $ingredient->translateOrNew('en')->description    = $request->get('description_en');

            $ingredient->translateOrNew('nb')->title          = $request->get('title_nb');
            $ingredient->translateOrNew('nb')->description    = $request->get('description_nb');

            $ingredient->save();

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