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
use App\ProductOption as ProductOption;
use App\Stockist as Stockist;
use Auth;
use App\Subscriber as Subscriber;
use App\Tag as Tag;
use App\Image as Image;
class PageController extends Controller
{

    public function index(){

        $slides = Slide::all();
        $featured_products = Product::where('featured', true)->get();
        $stockists = Stockist::all();
        return View::make('index', [
            'slides' => $slides, 
            'products' => $featured_products,
            'stockists' => $stockists
        ]);

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
