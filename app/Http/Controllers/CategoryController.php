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

class CategoryController extends Controller{

    public function index(){}

    public function show($slug){
        $paginate_count = (int) env('PAGINATION');
        $category = Category::where('slug', $slug)->first();
        $products = Product::where('category_id', $category->id)->orderBy("created_at", 'desc')->paginate($paginate_count);
        $data = array(
            'products'  => $products,
            'title'     =>  $category->title(),
            'page_title'    => trans($category->title())
        );
        return View::make('product.index')->with($data);
    }

    public function create(){
        $category = new Category;

        $data = array(
            'category'  => $category,
            'method' => 'post',
            'route' => 'category.store'
        );
        return View::make('category.create_or_edit')->with($data);
    }

    public function store(Request $request){
        $category = new Category;
        if( $category->validate_store($request->all()) ){
            if ($request->file('thumbnail')->isValid()) {
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
                return redirect()->route('category.show', $category->slug);
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
            'method' => 'put',
            'route' => 'category.update'
        );
        return View::make('category.create_or_edit')->with($data);
    }

    public function update(Request $request, $slug){
        $category = Category::where('slug', $slug)->first();
        $category->update( $request->all() );

        if($request->get('title')){
            $category->slug = Str::slug($request->get('title'));
        }

        if($request->file('thumbnail') && $request->file('thumbnail')->isValid()){
            $category->thumbnail = HelperController::upload_image($request->file('thumbnail'));
        }
        $category->save();
        return redirect()->route('category.show', $category->slug);
    }

    public function destroy($slug){
        Category::where('slug', $slug)->first()->delete();
        return back();
    }
}
