<?php

namespace App\Http\Controllers;

use App\Product as Product;
use App\Order as Order;
use Symfony\Component\Console\Helper\Helper;
use Validator;
use Illuminate\Http\Request;
use View;
use App\Http\Requests;
use Cart;
use Auth;
use App\User as User;
use Redirect;
use App\Http\Controllers\EmailController as EmailController;
use App\Http\Controllers\HelperController as HelperController;

class PaymentController extends Controller
{

    public function check_cart_user_active(){

        if(! Cart::count() ){
            return HelperController::render_message(
                trans('text.empty_cart_error'), 'alert-danger', trans('text.error')
            );
        }

        if (Auth::user() && !Auth::user()->active){
            return HelperController::render_message(
                trans('text.activate_account_message'), 'alert-danger', trans('text.error')
            );
        }
    }

    public function checkout(Request $request){

        // return to warning page if no items in the cart
        if($view = $this->check_cart_user_active()){return $view;}

        if($request->method() == "POST"){

            $validation_rules = [
                'name'      => 'required|max:255',

                'surname'   => 'required|max:255',
                'address_1' => 'required|max:255',
                'address_2' => 'max:255',
                'city'      => 'required|max:255',
                'country'   => 'required|max:255',
                'post_code' => 'required|max:20',
                'phone'     => 'required|max:50'
            ];
            if(! Auth::user()){
                $validation_rules['guest_email'] = 'required|email|max:255';
            }

            $validator = Validator::make($request->all(), $validation_rules);

            if ($validator->fails()) {
                return redirect('checkout')
                    ->withErrors($validator)
                    ->withInput();
            }

            $user = Auth::user();
            $payment_token = $request->input('stripeToken');

            // if the user is logged in, remember him
            if( $user && $request->input('remember_me')){
                $user->address_1 = $request->input('address_1');
                $user->city      = $request->input('city');
                $user->country   = $request->input('country');
                $user->post_code = $request->input('post_code');
                $user->phone     = $request->input('phone');

                if($request->input('address_2')){
                    $user->address_2 = $request->input('address_2');
                }
                $user->save();
            }

            if(! $user){
                $user = new User();
            }

            // shipping and cart price
            $cost = HelperController::calculate_shipping_cost($request->input('country'));
            $result = $user->charge($cost['total_lowest'] , [
                'source' => $payment_token,
            ]);

            // if charging unsuccessful, return error
            // TODO TEST THIS LINE
           

            if(! $result->getLastResponse()->code == 200){
                return Response('Charging unsuccessful', 400);
            }
            $last4 = $result->getLastResponse()->json['source']['last4'];
            # get email from input or from the current user
            $email="";
            if($email = $request->input('guest_email')  ) {}
            else {
              $email = $user->email;
            }

            $order = Order::create([
                'order_number'  => str_random(8),
                'email'         => $email,
                'first_name'    => $request->input('name'),
                'last_name'     => $request->input('surname'),
                'address_1'     => $request->input('address_1'),
                'city'          => $request->input('city'),
                'post_code'     => $request->input('post_code'),
                'country'       => $request->input('country'),
                'phone'         => $request->input('phone'),
                'total'         => $cost['total'],
                'shipping'      => $cost['shipping'],
                'last4'         => $last4
            ]);

            if($request->input('address_2')){
                $order->address_2 = $request->input('address_2');
            }
            $order->save();
            foreach (Cart::content() as $row) {
                $item_id = $row->id;
                $product = Product::find($item_id)->first();
                $option = $row->options->option;
                $order->products()->attach($product, ['quantity'=> $row->qty, 'option_id'=> $option->id] );
            }
//
            $data = [
                'order' => $order,
                'cart'  => Cart::content(),
            ];

            return EmailController::send_order_email($data);

        }
        
        $rate = HelperController::getRate();

        return View::make('checkout')->with('cart', Cart::total())->with('rate', $rate);
    }
}
