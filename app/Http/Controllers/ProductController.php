<?php

namespace App\Http\Controllers;
use View;
use App;
use Illuminate\Http\Request as Request;
use App\Product as Product;
use App\Category as Category;
use App\ProductTranslation as ProductTranslation;
use App\CategoryTranslation as CategoryTranslation;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ProductOption as ProductOption;
use App\Review as Review;
use DB;
use Cache;
use Config;
use Validator;
use Swap;

class ProductController extends Controller

{

    public function index(){
        $paginate_count = (int) env('PAGINATION');
//        $products = DB::table('product_translations')
//            ->select('product_translations.title as title',
//                'product_options.price as price',
//                'products.*',
//                'product_translations.description'
//            )
//            ->join('products', 'product_translations.product_id', '=', 'products.id')
//            ->join('product_options', 'product_options.product_id', '=', 'products.id')
//            ->where('product_translations.locale', '=', Config::get('app.locale')  )
//            ->groupBy('product_options.price')
//            ->paginate($paginate_count);
        $products = Product::whereHas('translations', function ($query) {
            $query->where('locale',  Config::get('app.locale')  );
        })->paginate($paginate_count);
//        dd($products);
//        $products = Product::paginate($paginate_count);
        $data = array(
            'products'  => $products,
            'title'     => trans('text.products')
        );
        
        return View::make('product.index')->with($data);
    }

    public function show(Request $request, $product_slug){
        $paginate_count = (int) env('PAGINATION');
        $option = $request->option;

        $product = Product::where('slug', $product_slug)->first();
        
        $selected_option = 0;
        // get option if specified (dropdown)
        if($option){
            $selected_option = ProductOption::where('product_id', $product->id)->where('slug', $option)->first();
        }
        // otherwise just fetch the first one
        if (!$selected_option) {
            $selected_option = ProductOption::where('product_id', $product->id)->first();    
        }
        // dd($selected_option);
        $data = array(
            'product'   => $product,
            'option'    => $selected_option,
            'rate'      => HelperController::getRate(),
            'reviews'   => Review::where('product_id', $product->id)->get()
        );
        return View::make('product.show')->with($data);
    }

    public function create(){
        $product = new Product();
        $categories = Category::all();
        $options = array();

        foreach ($categories as $category) {
            $options = array_add($options, $category->id, $category->title);
        }
        

        $data = array(
            'options'    => $options,
            'product' => $product,
        );
        return View::make('product.create')->with($data);
    }

    public function store(Request $request){

        $this->validate($request, [

            'title' => 'required|unique:posts|max:255',
            'author.name' => 'required',
            'author.description' => 'required',
        ]);


        $data = array(
            'alert_type'    => 'alert-success',
            'alert_text'    => 'woo',
            'message'       => 'Creation successful'
        );

        return View::make('message')->with($data);
    }

    public function edit(Request $request, $product_slug){
        $product = Product::where('slug', $product_slug)->first();
        $data = array(
            'product'   => $product,
        );
        return View::make('product.edit')->with($data);
    }
    
    public function search(Request $request){

        $term = $request->input('term');
        $products = Product::whereHas('translations', function ($query) use ($term){
            $query->where('title', 'LIKE', '%'.$term.'%');
        })->paginate($paginate_count);

        $data = array(
            'products'  => $products,
            'title'     => trans('text.searching_for') . " \"$term\""
        );
        return View::make('product.index')->with($data);
    }

}
