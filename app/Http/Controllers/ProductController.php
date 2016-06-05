<?php

namespace App\Http\Controllers;
use View;
use Illuminate\Support\Str as Str;
use App;
use Illuminate\Http\Request as Request;
use App\Tag as Tag;
use App\Product as Product;
use App\Category as Category;
use App\ProductTranslation as ProductTranslation;
use App\CategoryTranslation as CategoryTranslation;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ProductOption as ProductOption;
use App\Review as Review;
use App\Ingredient as Ingredient;
use DB;
use Cache;
use Config;
use Validator;
use Swap;
use Input;
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
            'categories'=> Category::all(),
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

        $category_options = DB::table('categories')
            ->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.locale', 'en')
            ->lists('category_translations.title', 'categories.id');

        $related_products = DB::table('products')
            ->join('product_translations', 'products.id', '=', 'product_translations.product_id')
            ->where('product_translations.locale', 'en')
            ->lists('product_translations.title', 'products.id');

        $all_ingredients = DB::table('ingredients')
            ->join('ingredient_translations', 'ingredients.id', '=', 'ingredient_translations.ingredient_id')
            ->where('ingredient_translations.locale', 'en')
            ->lists('ingredient_translations.title', 'ingredients.id');

        $data = array(
            'category_options'      => $category_options,
            'all_products'          => $related_products, # all related products
            'all_ingredients'       => $all_ingredients,
            'product'               => $product

        );
        return View::make('product.create')->with($data);
    }

    public function store(Request $request){
        $product = new Product();
        # exit if no options specified, or if an option is missing an argument
        # product price
        $opt_titles = $request->get('option_title');
        $opt_weights = $request->get('option_weight');
        $opt_prices = $request->get('option_price');

        if(empty( $opt_titles ) || !(( count($opt_titles) == count($opt_weights) || count($opt_weights) == count($opt_prices) )) ) {
            abort(400, 'Specify at least one product option and fill all fields in it !');
        }

        if( $product->validate_store($request->all()) ){

            $paths = HelperController::crop_image(
                $request->file('thumbnail'),
                'categories',
                $request->input('title_en'),
                array(env('MEDIUM_THUMBNAIL'),
                env('SMALL_THUMBNAIL'))
            );

            # base product and thumbnails

            $product = new Product([
                'slug'              => Str::slug($request->get('title_en') ),
                'thumbnail_full'    => $paths[0],
                'thumbnail_medium'  => $paths[1],
                'thumbnail_small'   => $paths[2],
            ]);

            $product->in_stock = (bool) $request->get('in_stock');

            # category

            $category = Category::find((int) $request->get('category'));
            $product->category()->associate($category);
            $product->save();

            for ($i=0; $i < count($opt_titles); $i++) {

                $dropdown_option = ProductOption::create([
                     'weight' => $opt_weights[$i],
                     'title' => $opt_titles[$i],
                     'slug'  => Str::slug($opt_titles[$i]),
                     'price' => $opt_prices[$i],
                     'product_id' => $product->id
                 ]);
            }

            # translations

            $product->translateOrNew('en')->title           = $request->get('title_en');
            $product->translateOrNew('en')->description     = $request->get('description_en');
            $product->translateOrNew('en')->tips            = $request->get('tips_en');
            $product->translateOrNew('en')->benefits        = $request->get('benefits_en');

            $product->translateOrNew('nb')->title           = $request->get('title_nb');
            $product->translateOrNew('nb')->description     = $request->get('description_nb');
            $product->translateOrNew('nb')->tips            = $request->get('tips_nb');
            $product->translateOrNew('nb')->benefits        = $request->get('benefits_nb');

            # tags

            $product->tags = $request->get('tags');
            if($request->get('hidden_tags')){
                $product->hidden_tags = $request->get('hidden_tags');
            }

            # related products
            $related = $request->get('related_products');

            if(! empty($related)){
                foreach($related as $rel){
                    $p_object = Product::find($rel);
                    # do it only if the object exists
                    if($p_object){
                        $product->related()->attach( $p_object );
                        $product->save();    
                    }
                }
                
            }

            # ingredients

            $ingredients = $request->get('ingredients');

            if(! empty($ingredients)){
                foreach($ingredients as $ing){
                    $i_object = Ingredient::find($ing);
                    if($i_object){
                        $product->ingredients()->attach( $i_object );
                        $product->save();                    
                    }
                }
                
            }

            $product->save();
        } else {
            return redirect()->route('product.create')
                ->withErrors($product->errors)
                ->withInput();
        }



        $data = array(
            'alert_type'    => 'alert-success',
            'alert_text'    => 'Product added successful',
            'message'       => 'Deleting ' . $request->get('title_en') . ' successful'
        );

        return View::make('message')->with($data);
    }

    public function edit($product_slug){

        $category_options = DB::table('categories')
            ->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.locale', 'en')
            ->lists('category_translations.title', 'categories.id');

        $all_products = DB::table('products')
            ->join('product_translations', 'products.id', '=', 'product_translations.product_id')
            ->where('product_translations.locale', 'en')
            ->lists('product_translations.title', 'products.id');

        $related_products = DB::table('product_related')
            ->where('product_related.product_id', 'product->id')
            ->join('products', 'products.id', '=', 'product_related.related_id')
            ->join('product_translations', 'product_translations.product_id', '=', 'products.id')
            ->where('product_translations.locale', 'en')
            ->lists('product_related.related_id');

//        $related_products = array(10,3);

        $data = array(
            'product'   => $product,
            'category_options'  => $category_options,
            'en_translation'    => ProductTranslation::where('product_id', $product->id)
                                                    ->where('locale','en')
                                                    ->first(),
            'nb_translation'    => ProductTranslation::where('product_id', $product->id)
                                                    ->where('locale','en')
                                                    ->first(),
            'all_products'       => $all_products,
            'related_products' => $related_products
        );

        return View::make('product.edit')->with($data);
    }

    public function update(Request $request){
        dd(Input::all());
    }

    public function search(Request $request){

        $term = $request->input('term');
        $products = Product::whereHas('translations', function ($query) use ($term){
            $query->where('title', 'LIKE', '%'.$term.'%');
        })->paginate( env('PAGINATION') );

        $data = array(
            'products'  => $products,
            'title'     => trans('text.searching_for') . " \"$term\""
        );
        return View::make('product.index')->with($data);
    }

    public function destroy($slug){
        $product = Product::where('slug', $slug)->first();
        if (!$product){
            return abort(404, "Product $slug not found");
        };
        $product->delete();

        $data = array(
            'alert_type'    => 'alert-success',
            'alert_text'    => 'Product added successful',
            'message'       => 'Deleting ' . $product->title . ' successful'
        );

        return View::make('message')->with($data);
    }

}
