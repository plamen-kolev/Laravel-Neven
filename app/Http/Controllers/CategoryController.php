<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str as Str;
use App\Http\Requests;
use App\Category as Category;
use View;
use App\Http\Controllers\HelperController as HelperController ;
class CategoryController extends Controller
{
    public function show($category_slug){
        $paginate_count = (int) env('PAGINATION');
//        == OPTIMIZED ===
//        $products = DB::table('product_translations')
//            ->select('product_translations.title as title',
//                'product_options.price as price',
//                'products.id as id',
//                'products.category_id',
//                'products.slug',
//                'products.thumbnail',
//                'products.in_stock',
//                'product_translations.description'
//            )
//            ->join('products', 'product_translations.product_id', '=', 'products.id')
//            ->join('categories', 'products.category_id', "=", 'categories.id')
//            ->join('product_options', 'product_options.product_id', '=', 'products.id')
//            ->where('product_translations.locale', '=', Config::get('app.locale')  )
//            ->where('categories.slug', $category_slug)
//            ->groupBy('product_options.price')
//            ->paginate($paginate_count);

//      == unoptimized ==
        $category = Category::where('slug', $category_slug)->first();
        $products = $category->products()->paginate($paginate_count);

        $data = array(
            'products'  => $products,
            'title'     => "Category " . $category->title
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
        $this->validate($request, [
            'title_en'          => 'required|max:255',
            'title_nb'          => 'required|max:255',
            'description_en'    => 'required|max:255',
            'description_nb'    => 'required|max:255',
            'thumbnail'         => 'required|max:10000|mimes:jpeg,jpg,png'
        ]);    

        if ($request->file('thumbnail')->isValid()) {
            $data = array(
                'alert_type'    => 'alert-success',
                'alert_text'    => 'woo',
                'message'       => 'Creation successful'
            );


            $paths = HelperController::cropImage($request->file('thumbnail'), 'categories', $request->input('title_en'), array(640, 150));
            $category = new Category([
                'thumbnail_full'    => $paths[0],
                'thumbnail_medium'  => $paths[1],
                'thumbnail_small'   => $paths[2],
                'slug'      =>  Str::slug($request->get('title_en'))
            ]);

            $category->save();
            
            $category->translateOrNew('en')->title          = $request->get('title_en');
            $category->translateOrNew('en')->description    = $request->get('description_en');

            $category->translateOrNew('nb')->title          = $request->get('title_nb');
            $category->translateOrNew('nb')->description    = $request->get('description_nb');

            $category->save();
            
            return View::make('message')->with($data);
        }

        return Response('File upload failed', 400);
    }
}
