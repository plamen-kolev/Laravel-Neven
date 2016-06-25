<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str as Str;
use App\Http\Requests;
use App\Category as Category;
use App\Product as Product;
use View;
use DB;
use App\Http\Controllers\HelperController as HelperController ;

class CategoryController extends Controller
{
    public function show($slug){
        $paginate_count = (int) env('PAGINATION');
        $category = Category::where('slug', $slug)->first();
        // $products = $category->products()->paginate($paginate_count);
        $products = Product::where('category_id', $category->id)->orderBy("created_at", 'desc')->paginate($paginate_count);
        $data = array(
            'products'  => $products,
            'title'     => "Category " . $category->title(),
            'page_title'    => ' - ' . trans($category->title())
        );
//      == END ==
        return View::make('product.index')->with($data);
    }

    public function create(){
        $category = new Category;
        
        $data = array(
            'category'  => $category
        );
        return View::make('category.create')->with($data);
    }

    public function store(Request $request){
        $category = new Category;

        if( $category->validate_store($request->all()) ){
        

            if ($request->file('thumbnail')->isValid()) {
                $data = array(
                    'alert_type'    => 'alert-success',
                    'alert_text'    => 'Category created successfully',
                    'message'       => 'Creation successful'
                );

                $image = HelperController::upload_image($request->file('thumbnail') );
                
                $category = new Category([
                    'thumbnail'    => $image,
                    'slug'      =>  Str::slug($request->get('title_en')),

                    'title_en'          => $request->get('title_en'),
                    'description_en'    => $request->get('description_en'),

                    'title_nb'          => $request->get('title_nb'),
                    'description_nb'    => $request->get('description_nb')
                ]);

                $category->save();
                
                return View::make('message')->with($data);
            }


            return Response('File upload failed', 400);
        } else {
            return redirect()->route('category.create')
                ->withErrors($category->errors)
                ->withInput();
        }
    }

    public function edit($slug){
        $category = Category::where('slug', $slug)->first();

        if (!$category){
            return abort(404, "Category $slug not found");
        };

        $data = array(
            'category'   => $category,
            'en_translation'    => CategoryTranslation::where('category_id', $category->id)
                                                    ->where('locale','en')
                                                    ->first(),
            'nb_translation'    => CategoryTranslation::where('category_id', $category->id)
                                                    ->where('locale','en')
                                                    ->first(),
        );

        return View::make('category.edit')->with($data);
    }

    public function destroy($slug){
        $category = Category::where('slug', $slug)->first();
        if (!$category){
            return abort(404, "Category $slug not found");
        };
        $category->delete();

        $data = array(
            'alert_type'    => 'alert-success',
            'alert_text'    => 'Product added successful',
            'message'       => 'Deleting ' . $category->title . ' successful'
        );

        return View::make('message')->with($data);
    }
}
