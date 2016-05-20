<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use Config;
use App\Product as Product;
use View;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ProductTranslation as ProductTranslation;

class CartController extends Controller
{
    public function show_cart(Request $request){
        $method = $request->method();
        if ($method == "POST"){
            $updated_items = $request->except('_token');
            foreach($updated_items as $rowId => $quantity){
                Cart::update($rowId, $quantity);
            }
        }
        $cart = Cart::content();
        $data = array(
            'rate'      => HelperController::getRate(),
            'cart'      => $cart
        );
        return View::make('cart')->with($data);
    }

    public function add_to_cart(Request $request){
        $this->validate($request, [
            'product_slug' => 'required|max:255',
            'option_slug'  => 'required|max:255',
            'quantity'     => 'required|integer|min:0'
        ]);

        $product_slug   = $request->input('product_slug');
        $option_slug    = $request->input('option_slug');
        $quantity       = (int) $request->input('quantity');

        $product = Product::where('slug', $product_slug)->first();
        $option = $product->getOption($option_slug);


        HelperController::addToCart($data = [
            'product'   => $product,
            'option'    => $option,
            'qty'  => $quantity
        ]);
        return \Response::make("Item {$product->title} ({$option->title}) added", 200);
    }

    function remove_cart_item(Request $request, $rowid){
        Cart::remove($rowid);
        return \Response::make("Cart item removed", 200);
    }

    function destroy_cart(Request $request){
        Cart::destroy('main');
        return \Response::make("Cart items removed", 200);
    }
}
