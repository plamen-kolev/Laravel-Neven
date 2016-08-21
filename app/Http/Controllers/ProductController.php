<?php

namespace App\Http\Controllers;
use View;
use Illuminate\Support\Str as Str;
use App;
use Illuminate\Http\Request as Request;
use App\Tag as Tag;
use App\Product as Product;
use App\Category as Category;
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
use App\Image as Image;
use Input;
class ProductController extends Controller{
    public function index(){
        $paginate_count = (int) env('PAGINATION');
        $products = Product::orderBy("created_at", 'desc')->paginate($paginate_count);
        $data = array(
            'products'  => $products,
            'categories'=> Category::all(),
            'title'     => trans('text.categories'),
            'page_title' => trans('text.all_products_title')
        );

        return View::make('product.index')->with($data);
    }

    public function show(Request $request, $product_slug){
        $paginate_count = (int) env('PAGINATION');
        $option = $request->option;

        $product = Product::where('slug', $product_slug)->first();

        $selected_option = 0;
        if($option){
            $selected_option = ProductOption::where('product_id', $product->id)->where('slug', $option)->first();
        }
        // otherwise just fetch the first one
        if (!$selected_option) {
            $selected_option = ProductOption::where('product_id', $product->id)->first();
        }
        $data = array(
            'product'   => $product,
            'option'    => $selected_option,
            'rate'      => HelperController::get_rate(),
            'reviews'   => Review::where('product_id', $product->id)->get(),
            'page_title'    => trans($product->title())
        );
        return View::make('product.show')->with($data);
    }

    public function create(){
        $product = new Product();

        $category_options = Category::all()
            ->lists('title_en', 'id');

        $all_products = Product::all()
            ->lists('title_en', 'id');

        $all_ingredients = Ingredient::all()
            ->lists('title_en','id');

        // if no objects, give blank collection
        foreach ([$category_options, $all_products, $all_ingredients] as $obj) {
            if(!$obj){
                $obj = collect([]);
            }
        }

        if(!$category_options){
            $category_options = collect([]);
        }

        $data = array(
            'category_options'      => $category_options,
            'all_products'          => $all_products, # all related products
            'all_ingredients'       => $all_ingredients,
            'related_ingredients'   => collect([]),
            'related_products'      => collect([]),
            'product'               => $product,

            'selected_category'     => '',
            'options'               => array(),
            'method'                => 'post',
            'route'                 => 'product.store'

        );
        return View::make('product.create_or_edit')->with($data);
    }

    public function store(Request $request){
        $product = new Product();
        # exit if no options specified, or if an option is missing an argument
        # product price
        $opt_titles = $request->get('option_title');
        $opt_weights = $request->get('option_weight');
        $opt_prices = $request->get('option_price');

        if(!$opt_titles[0] || !$opt_weights[0] || !$opt_prices[0]){
            abort(400, 'Specify at least one product option and fill all fields in it !');
        }

        if(empty( $opt_titles ) || !(( count($opt_titles) == count($opt_weights) || count($opt_weights) == count($opt_prices) )) ) {
            abort(400, 'Specify at least one product option and fill all fields in it !');
        }

        if( $product->validate_store($request->all()) ){
            $hover_name = '';
            if($request->file('hover_thumbnail') && $request->file('hover_thumbnail')->isValid()){
                $hover_name = HelperController::upload_image($request->file('hover_thumbnail'));
            } else {
                $hover_name = HelperController::upload_image($request->file('thumbnail'));
            }

            $thumbnail = HelperController::upload_image($request->file('thumbnail'));
            # base product and thumbnails
            $product = new Product([
                'slug'              => Str::slug($request->get('title_en') ),
                'thumbnail'         => $thumbnail,
                'hover_thumbnail'   => $hover_name,

                'category_id'       => Category::find((int) $request->get('category'))->id,
                'in_stock'        => (bool) $request->get('in_stock'),

                'featured'        => (bool) $request->get('featured'),

                'title_en'           => $request->get('title_en'),
                'description_en'     => $request->get('description_en'),
                'tips_en'            => $request->get('tips_en'),
                'benefits_en'        => $request->get('benefits_en'),

                'title_nb'           => $request->get('title_nb'),
                'description_nb'     => $request->get('description_nb'),
                'tips_nb'            => $request->get('tips_nb'),
                'benefits_nb'        => $request->get('benefits_nb'),
            ]);

            $product->save();

            if($request->file('images') && $request->file('images')[0]){

                foreach($request->file('images') as $image){
                    Image::create([
                        'thumbnail'   => HelperController::upload_image( $image ),
                        'product_id'        => $product->id
                    ]);

                }
            }

            for ($i=0; $i < count($opt_titles); $i++) {

                ProductOption::create([
                    'weight' => $opt_weights[$i],
                    'title' => $opt_titles[$i],
                    'slug'  => Str::slug($opt_titles[$i]),
                    'price' => $opt_prices[$i],
                    'product_id' => $product->id
                ]);
            }

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

        return redirect()->route('product.show', $product->slug);
    }

    public function edit($slug){

        $product = Product::where('slug', $slug)->first();
        $category_options = DB::table('categories')
            ->lists('categories.title_en', 'categories.id');

        $all_ingredients = DB::table('ingredients')
            ->lists('title_en','id');

        $all_products = DB::table('products')
            ->lists('products.title_en', 'products.id');

        $related_ingredients = DB::table('ingredient_product')
            ->where('ingredient_product.product_id', $product->id)
            ->lists('ingredient_product.ingredient_id');

        $related_products = DB::table('product_related')
            ->where('product_related.product_id', $product->id)
            ->lists('product_related.related_id');

        $selected_category = $product->category()->first()->id;

        $options = $product->options()->get();

        $data = array(
            'product'   => $product,
            'category_options'  => $category_options,
            'all_ingredients'   => $all_ingredients,
            'options'           => $options,
            'related_ingredients' => $related_ingredients,
            'selected_category' => $selected_category,
            'all_products'      => $all_products,
            'related_products'  => $related_products,

            'method'            => 'put',
            'route'             => 'product.update'
        );


        return View::make('product.create_or_edit')->with($data);
    }

    public function update(Request $request, $id){
        $product = Product::where('id', $id)->first();

        $opt_titles = $request->get('option_title');
        $opt_weights = $request->get('option_weight');
        $opt_prices = $request->get('option_price');

        if(!$opt_titles[0] || !$opt_weights[0] || !$opt_prices[0]){
            abort(400, 'Specify at least one product option and fill all fields in it !');
        }

        if(empty( $opt_titles ) || !(( count($opt_titles) == count($opt_weights) || count($opt_weights) == count($opt_prices) )) ) {
            abort(400, 'Specify at least one product option and fill all fields in it !');
        }

        for ($i=0; $i < count($opt_titles); $i++) {
            $option = ProductOption::where('product_id', $product->id)
                                    ->where('title', $opt_titles[$i])
                                    ->where('weight', $opt_weights[$i])
                                    ->first();

            if(!$option){
                ProductOption::create([
                    'weight' => $opt_weights[$i],
                    'title' => $opt_titles[$i],
                    'slug'  => Str::slug($opt_titles[$i]),
                    'price' => $opt_prices[$i],
                    'product_id' => $product->id
                ]);
            } else {
                $option->update([
                    'title' => $opt_titles[$i],
                    'weight' => $opt_weights[$i],
                    'price' => $opt_prices[$i]
                ]);
            }

        }

        $product->update($request->all());
        if($request->file('thumbnail')){
            $product->thumbnail = HelperController::upload_image($request->file('thumbnail'));
        }
        $product->save();
        return redirect()->route('product.show', $product->slug);
    }

    public function search(Request $request){

        $term = $request->input('term');
        $products = Product::where('title_en', 'LIKE', '%'.$term.'%')
            ->orWhere('title_nb', 'LIKE', '%'.$term.'%')
            ->orWhere('tags', 'LIKE', '%'.$term.'%')
            ->orWhere('hidden_tags', 'LIKE', '%'.$term.'%')
            ->paginate( env('PAGINATION') );

        $data = array(
            'products'  => $products,
            'title'     => trans('text.searching_for') . " \"$term\"",
            'page_title'    => trans('text.search_title') . " \"$term\""
        );
        return View::make('product.index')->with($data);
    }

    public function destroy($slug){
        $product = Product::where('slug', $slug)->first()->delete();
        return back();
        // return View::make('message')->with($data);
    }

}
