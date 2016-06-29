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
use DB;
use App\Ingredient as Ingredient;
use App\Product as Product;
use App\Category as Category;
use Illuminate\Support\Str as Str;
use App\ProductOption as ProductOption;
use App\Stockist as Stockist;
use Auth;
use App\Subscriber as Subscriber;
use App\Tag as Tag;
use App\Hero as Hero;
use App\Image as Image;
use Cache;

class PageController extends Controller
{

    public function index(){
        
        $stockists = Stockist::all();
        $hero = Hero::orderByRaw(DB::raw('RAND()'))->first();

        if(Cache::has('index_slides')){
            $slides = Cache::get('index_slides');

        } else {
            $slides = Slide::orderBy('id', 'desc')->get();    
            Cache::add('index_slides', $slides, env('CACHE_TIMEOUT'));
        }

        if(Cache::has('all_products')){
            $featured_products = Cache::get('all_products');
        } else {
            $featured_products = Product::where('featured', true)->get();
            Cache::add('all_products', $featured_products, env('CACHE_TIMEOUT'));
        }
        

        $data = [
            'slides' => $slides, 
            'products' => $featured_products,
            'stockists' => $stockists,
            'hero'      => $hero,
            'page_title'    => trans('text.home_title')
            
        ];

        return View::make('index', $data);

    }

    public function about(){
        $data = [
            'page_title'    => ' - ' . trans('text.about_us')
        ];
        return View::make('about', $data);
    }

    public function contact(Request $request){
        if($request->isMethod('POST')){
            $this->validate($request, [
                'first_name'    => 'required|max:255|string',
                'last_name'     => 'required|max:255|string',
                'email'         => 'required|max:255|email',
                'telephone'     => 'required|numeric',
                'about'       => 'required|max:5000|'
            ]);

            EmailController::send_contact_email($request->all());
        }

        return View::make('contact', ['page_title' => trans('text.contact_us_title')]);
    }


    public function subscribe(Request $request){

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



    public function admin(){
        return View::make('admin');
    }

}
