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

        $data = array(
            'category_options'      => HelperController::object_to_dropdown( Category::all() ),
            'product_options'       => HelperController::object_to_dropdown( Product::all() ), # all related products
            'product'               => $product
        );
        return View::make('product.create')->with($data);
    }

    public function store(Request $request){
        $this->validate($request, [

            'title_en'          => 'unique:product_translations,title|required|max:1000',
            'title_nb'          => 'required|max:1000',

            'description_en'    => 'required',
            'description_nb'    => 'required',

            'weight'            => 'required|numeric',
            'price'             => 'required|numeric',


            'tips_en'           => 'required',
            'tips_nb'           => 'required',

            'benefits_en'       => 'required',
            'benefits_nb'       => 'required',

            'thumbnail'         => 'required|max:10000|mimes:jpeg,jpg,png',
            'category'          => 'required|Integer',
            'tags'              => 'required',

        ]);

        $paths = HelperController::crop_image(
            $request->file('thumbnail'),
            'categories',
            $request->input('title_en'),
            array(env('MEDIUM_THUMBNAIL'),
            env('SMALL_THUMBNAIL'))
        );

        # base product and thumbnails

        $product = new Product([
            'slug'              => Str::slug($request->get('title_en')),
            'thumbnail_full'    => $paths[0],
            'thumbnail_medium'  => $paths[1],
            'thumbnail_small'   => $paths[2],
        ]);

        $product->in_stock = (bool) $request->get('in_stock');

        # category

        $category = Category::find((int) $request->get('category'));
        $product->category()->associate($category);
        $product->save();

        # product price
        $dropdown_option = ProductOption::create([
            'weight' => $request->get('weight'),
            'title' => $request->get('option_title'),
            'slug'  => Str::slug($request->get('option_title')),
            'price' => $request->get('price'),
            'product_id' => $product->id
        ]);

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

        if(empty($related)){
            foreach($related as $rel){
                $r = Product::find($rel);
                $r->related()->attach($product);
                $r->save();
            }
            
        }

        $product->save();
        return redirect()->route('product.edit', $product->slug);
    }

    public function edit(Request $request, $product_slug){
        $product = Product::where('slug', $product_slug)->first();

        $data = array(
            'product'   => $product,
            'category_options'  => HelperController::object_to_dropdown( Category::all() ),
            'en_translation'    => ProductTranslation::where('product_id', $product->id)
                                                    ->where('locale','en')
                                                    ->first(),
            'nb_translation'    => ProductTranslation::where('product_id', $product->id)
                                                    ->where('locale','en')
                                                    ->first()
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
        $article = Product::where('slug', $slug)->first();
        if (!$article){
            return abort(404, "Product $slug not found");
        };
        $article->delete();

        $data = array(
            'alert_type'    => 'alert-success',
            'alert_text'    => 'Product added successful',
            'message'       => 'Deleting ' . $article->title . ' successful'
        );

        return View::make('message')->with($data);
    }

}
