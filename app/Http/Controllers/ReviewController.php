<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App;
use Input;
use Validator;
use App\Product as Product;
use App\Review as Review;
use Illuminate\Routing\Route;
use App\Http\Requests;

class ReviewController extends Controller
{
    public function store(Request $request){

        # ignore request if not logged int
        if ( Auth::user() ){
            $validator = Validator::make($request->all(), [
                'body'      => 'required|max:5000',
                'rating'    => 'required|between:1,5',
                'product'   => 'required|string'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
            }

            # get product that is being reviewed
            $product = Product::where('slug', Input::get('product'))->first();
            
            if(empty($product)){
                return response("Product " . Input::get('product') . " not found", 404);
            }

            $review = new Review([
                'body'      => Input::get('body'),
                'rating'    => Input::get('rating')
            ]);

            $review->product()->associate($product);
            $review->user()->associate(Auth::user());
            $review->save();
            return response('Thank you for the review!', 200);
            
        } else {
            return response('You need to log in to write a review!',401) ;
        }
   
    }

    public function destroy(Request $request){
        $id = (int) Input::get('id');
        
        $review = Review::find($id);
        if(empty($review->first())){
            return response("Review not found", 404);
        }
        if($review->user != Auth::user()){
            return response("You are not authorized to delete this review", 401);
        } else {
            $review->delete();
        }
        return response('Review deleted successfully!',200) ;
    }
}
