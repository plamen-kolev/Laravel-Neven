<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Slide as Slide;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use Validator;
use App\Article as Article;
use Session;
use App\Ingredient as Ingredient;
use App\Product as Product;
use App\Category as Category;
use Illuminate\Support\Str as Str;
use App\CategoryTranslation;
use App\ProductOption as ProductOption;
use App\IngredientTranslation as IngredientTranslation;
use Auth;
use App\Subscriber as Subscriber;
use App\Tag as Tag;
use App\Image as Image;
class PageController extends Controller
{

    public function index(){

        $slides = Slide::all();
        $featured_products = Product::where('featured', true)->get();

        return View::make('index', [
                'slides' => $slides, 
                'featured_products' => $featured_products
        ]);

    }
    public function xmlparse(){
        $items = simplexml_load_file(app_path() . '/../items.xml');
        for ($x = 0; $x < 4; $x++) {
            $this->fill_item($x, $items);
        }
    }

    function fill_item($index, $items){

        $item = $items->item[$index];

//        create category
        $category_obj = new Category();
        $category_obj->thumbnail =  $item->xpath('./categories/category[@lang="en"]/thumbnail')[0];
        $category_obj->slug =  Str::slug($item->xpath('./categories/category[@lang="en"]/title')[0]);

        foreach ($item->categories->category as $category){
            $language = $category['lang'];
//            print ($category->title .  $category['lang']  . "  ...... ");
            if(CategoryTranslation::where('title', $category->title)->count()){
                print "this category exists";
                // break out of the foreach loop immediatly
                continue;
//          translation not found, create category
            } else{
                $category_obj->save();
                $category_obj->translateOrNew($language)->title = $category->title;
                $category_obj->translateOrNew($language)->description =  $category->description;
                $category_obj->save();
            }
        }

        // CATEGORY CODE ENDS HERE
        // ADD INGREDIENTS CODE HERE
        $ingredients_en = $item->xpath('./ingredients/translation[@lang="en"]/ingredient');
        $ingredients_no = $item->xpath('./ingredients/translation[@lang="nb"]/ingredient');

        $counter = 0;
        foreach($ingredients_en as $ing){
            $ingredient_obj = new Ingredient();
            if(Ingredient::where('slug', Str::slug($ing)  )->count()){
                ++$counter;
                continue;
            }

            $ingredient_obj->thumbnail = 'changeme';
            $ingredient_obj->slug = Str::slug($ing);
            $ingredient_obj->save();
            $ingredient_obj->translateOrNew('en')->description = "changeme";
            $ingredient_obj->translateOrNew('en')->title = $ing;

            $ingredient_obj->translateOrNew('nb')->description = "changeme";
            $ingredient_obj->translateOrNew('nb')->title = $ingredients_no[$counter];
            $ingredient_obj->save();
            ++$counter;
        }
        // end ingredient creation

        // Product creation here (the hard part)
        $product_obj = new Product();
        $product_obj->id = $item->id;
        $product_obj->slug = Str::slug(     $item->xpath('./titles/title[@language="en"]')[0]   );
        $product_obj->thumbnail = $item->thumbnail;
//        $product_obj->save();
        // associate the product with a category
        $product_obj->category()->associate(  Category::where('slug', $category_obj->slug )->first()  );
        $product_obj->save();

        // Create translations for the product
        $product_obj->translateOrNew('en')->title = $item->xpath('./titles/title[@language="en"]')[0];
        $product_obj->translateOrNew('nb')->title = $item->xpath('./titles/title[@language="nb"]')[0];

        $product_obj->translateOrNew('en')->description = $item->xpath('./descriptions/description[@lang="en"]')[0]->asXML();
        $product_obj->translateOrNew('nb')->description = $item->xpath('./descriptions/description[@lang="nb"]')[0]->asXML();
        $product_obj->save();

        // Create options
        foreach($item->xpath('./options/option') as $option) {
            $option_obj = new ProductOption();
            $option_obj->title = $option->name;
            $option_obj->slug = Str::slug($option->name);
            $option_obj->price = ($option->price);
            $option_obj->product_id = $product_obj->id;
            $option_obj->save();
        }

        // Related images
        foreach($item->xpath('./images/image') as $image){
            if(Image::where('url', $image)->count()){
                continue;
            }
            $image_obj = new Image();
            $image_obj->url =  $image;
            $image_obj->product_id = $product_obj->id;
            $image_obj->save();
        }

        // Tags
        foreach($item->xpath('./tags/tag') as $tag){
            if(Tag::where('title', $tag)->count()){
                continue;
            } else {
                $tag_obj = new Tag();
                $tag_obj->title = $tag;
                $tag_obj->slug = Str::slug($tag);
                $tag_obj->product_id = $product_obj->id;
                $tag_obj->save();
            }
        }

        // Associate ingredients
        foreach($item->xpath('./ingredients/translation[@lang="en"]/ingredient') as $ingredient){
            $ingredient = IngredientTranslation::where('title', $ingredient)->first()->ingredient()->first();
            $product_obj->ingredients()->attach($ingredient);
            $product_obj->save();
        }

        return 1;
    }

    public function subscribe(Request $request){
        $this->validate($request, [

        ]);

        $validator = Validator::make($request->all(), [
            'subscribe_email'    => 'unique:subscribers,email|required|max:255|email',

        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'subscribe_email')
                ->withInput();
        } else {
            Subscriber::create(['email' => $request->get('subscribe_email')]);
        }

        return Response("Email " . $request->get('subscribe_email') . " subscribed succesfully !", 200);
    }

    public function stockist(Request $request){
        if ($request->method() == 'POST'){
            $this->validate($request, [
                'first_name'    => 'required|max:255|string',
                'last_name'     => 'required|max:255|string',
                'email'         => 'required|max:255|email',
                'website'       => 'required|max:255|string',
                'company'       => 'required|max:255|string',
                'about_you'     => 'required|max:5000|'

            ]);
            EmailController::send_stockist_email(
                Input::get('first_name'),
                Input::get('last_name'),
                Input::get('email'),
                Input::get('website'),
                Input::get('company'),
                Input::get('about_you')
            );
            $our_response = [
                'alert_text' => 'Thank you !', 
                'alert_type' =>'success',
                'message'    => 'Thank you',
            ];
            return View::make('message', $our_response);
        }
        return View::make('stockist');
    }



    public function admin(){
        return View::make('admin');
    }

}
