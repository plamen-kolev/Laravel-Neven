<?php

namespace App\Http\Controllers;
use App\Ingredient as Ingredient;
use View;
use Illuminate\Support\Str as Str;
use Illuminate\Http\Request;
use App\Product as Product;
use App\Http\Requests;

class IngredientController extends Controller
{
    public function get_ingredients_for_product($product_slug){
        $product = Product::where('slug', $product_slug)->first();
        return (string) $product->ingredients()->get();
    } 

    public function index(){
        $data = [
            'ingredients' => Ingredient::orderBy('id', 'desc')->get()
        ];
        return View::make('ingredient.index', $data);
    }

    public function show($slug){
        $ingredient = Ingredient::where('slug', $slug)->first();
        if(!$ingredient){
            abort(404, "Ingredient $slug was not found");
        }
        return View::make('ingredient.show')->with('ingredient', $ingredient);
    }

    public function create(){
        $ingredient = new Ingredient();
        $data = [
            'ingredient' => $ingredient,
            'method' => 'post',
            'route' => 'ingredient.store'
        ];
        return View::make('ingredient.create_or_edit')->with($data);
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
            
            $ingredient = Ingredient::create([
                'thumbnail'    => HelperController::upload_image( $request->file('thumbnail') ),
                'title_en'  => $request->get('title_en'),
                'title_nb'  => $request->get('title_nb'),
                'description_en' => $request->get('description_en'),
                'description_nb' => $request->get('description_nb'),
                'slug'      =>  Str::slug($request->get('title_en'))
            ]);
            return redirect()->route('ingredient.show', $ingredient->slug);
        }
        return Response('File upload failed', 400);
    }

    public function edit($slug){
        $ingredient = Ingredient::where('slug', $slug)->first();
        if (!$ingredient){
            return abort(404, "Category $slug not found");
        };
        $data = array(
            'ingredient'   => $ingredient,
            'method' => 'put',
            'route' => 'ingredient.update'
        );
        return View::make('ingredient.create_or_edit')->with($data);
    }

    public function update(Request $request, $slug){
        $ingredient = Ingredient::where('slug', $slug)->first();
        $ingredient->update( $request->all() );

        if($request->get('title')){
            $ingredient->slug = Str::slug($request->get('title'));
        }

        if($request->file('thumbnail') && $request->file('thumbnail')->isValid()){
            $ingredient->thumbnail = HelperController::upload_image($request->file('thumbnail'));
        }
        $ingredient->save();
        
        return redirect()->route('ingredient.show', $ingredient->slug);
    }

    public function destroy($slug){
        Ingredient::where('slug', $slug)->first()->delete();
        eturn redirect()->route('ingredient.index', $ingredient->slug);
    }
}
