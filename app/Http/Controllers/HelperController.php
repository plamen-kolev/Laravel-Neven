<?php

namespace App\Http\Controllers;

use Config;
use Illuminate\Http\Request;
use Symfony\Component\Console\Helper\Helper;
use View;
use App\Http\Requests;
use Illuminate\Support\Str as Str;
use Swap;
use File;
use Image;
use App\ShippingOption as ShippingOption;
use Cart;
use Storage;
use Cache;

class HelperController extends Controller
{
    public static function upload_image($image_input){        
        $filename = $image_input->getClientOriginalName();
        Storage::disk(env('FILESYSTEM'))->put('images/' . $filename, File::get($image_input) );    
        return $filename;
    }
    
    public static function add_to_cart($data){
        // calculate weight
        $product = $data['product'];
        $option  = $data['option'];
        $total_weight = 0;
        for ($i=0; $i < $data['qty']; $i++) {
            $total_weight += $option->weight;
        }

        Cart::add(array(
            'id'        => $product->id,
            'name'      => $product->title(),
            'qty'       => $data['qty'],
            'price'     => $option->price,
        
            'options'=> array(
                'option'    => $option,
                'thumbnail' => $product->thumbnail,
                'weight'    => $total_weight
            )
        ));

        return 1;
    }

    public static function use_cache($item, $cache_name, $directive){
        if(Cache::has($cache_name)){
            return Cache::get($cache_name);
        } else {
            $fetched = $item->$directive();
            Cache::put($cache_name, $fetched, env('CACHE_TIMEOUT'));
            return $fetched;
        }

    }

    public static function get_stripe_currency(){
        $lang = Config::get('app.locale');
        if($lang == 'en'){
            return 'EUR';
        } else {
            return 'NOK';
        }
    }

    public static function getCurrencySymbol(){
        if( Config::get('app.locale') == 'en' ){
            return '&euro;';
        } else {
            return 'kr';
        }
    }

    public static function getRate(){
        $location = Config::get('app.locale');
        if ( ! env('CONVERT_CURRENCY') or $location = 'nb') {
            return 1;
        }
        #by default 10 NOK equals to 10*1=10 NOK
        if( $location == 'en' ){
            $rate = Swap::quote('NOK/EUR')->getValue();
        }
        return $rate;

    }

    public static function get_price($price){
        return round(HelperController::getRate() * $price, 2);
    }

    // will see how much the cart weights and where it is send to, returning a price according to the Shipment options object
    public static function calculate_shipping_cost($country_code){
        # get total weight
        $total_weight = 0;
        foreach (Cart::content() as $row) {
            $total_weight += (int) $row->options->weight;
        }

        $option = ShippingOption::where('country_code', $country_code)
            ->where('weight', '>=', $total_weight)
            ->orderBy('weight', 'asc')
            ->first();

        if(!$option){
            $option = ShippingOption::where('country_code', 'ALL')
                ->where('weight', '>', $total_weight)
                ->orderBy('weight', 'asc')
                ->first();
        }

        if(!$option){
            return "We cannot ship the specified weight";
        }

        $shipping_cost = HelperController::get_price($option->price);
        $product_cost = HelperController::get_price(Cart::total());
        $total = HelperController::get_price( $shipping_cost + $product_cost ) ;
        $costs = [
            'shipping_lowest'  => $shipping_cost * 100,
            'product_lowest'   => $product_cost * 100,
            
            'shipping'         => $shipping_cost,
            'product'          => $product_cost,

            'total_lowest'     => $total * 100,
            'total'            => $total
        ];
        return $costs;
    }


    public static function render_message($message, $alert_type, $alert_text ){
        $data = [
            'message'   => $message,
            'type'=> $alert_type,
            'alert_text'=> $alert_text
        ];
        return View::make('message', $data);
    }

    public static function hangon(){
        print "Press any key to continue";
        fgets(STDIN);
    }


    # Testing helpers
    public static function fill_valid_bank_details_and_submit($I){
        $I->fillField('#card_number_input', '4242424242424242');
        $I->fillField('#cvc_number_input', '123');
        $I->selectOption("#exp_element", 'December');
        $I->click('#submitform');
         sleep(2);
    }

    public static function iterate_and_fill_form($I, $input_id, $text, $expected_errors){
        $I->fillField($input_id, $text );
        HelperController::fill_valid_bank_details_and_submit($I);
        
        $counter = 5;
        while($counter){
            $error_count = $I->grabMultiple('.alert-danger');
            if($expected_errors == count($error_count)){
                $I->assertTrue($expected_errors == count($error_count));
                return 1;
            }
            sleep(1);
            $counter--;
        }
        
    }

    public static function fill_valid_address($I){
        $I->fillField('#row1_input', 'Name');
        $I->fillField('#row2_input', 'Surname');
        $I->fillField('#row3_input', 'Address');
        $I->fillField('#row4_input', 'Address part2');
        $I->fillField('#row5_input', 'City');
        $I->fillField('#row7_input', 'Post Code');
        $I->fillField('#row8_input', '088888');
    }

    public static function login($I, $email, $password){
       $I->amOnPage('/');
       $I->click('.hamburger_toggle');
       $I->click('.login_button');
       $I->fillField('#login_email_field', $email);
       $I->fillField('#password', $password);
       $I->click('#login_form_button');
    }

    public static function create_account($I, $username, $email, $password){
        $I->amOnPage( route('auth.register') );
        $I->fillField('.input_name', $username);
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->fillField('password_confirmation', $password);

        $I->click('#user_register_button');

        $I->seeRecord('users', ['email' => $email]);
        $user =  \App\User::where('email',$email)->first();

        $active = (bool) $user->active;
        $I->assertFalse($active);

        return $user;
    }

    public static function common_login($I, $name, $email, $password){
        $user = HelperController::create_account($I, $name, $email, $password);
    //        user is logged in automatically first time, so visit logout page first
        $I->click( trans('text.log_out') );

        $I->amOnPage( route('auth.login') );
        $I->see( trans('text.forgotten_password_question') );
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click( '#login_form_button' );
        $I->see( $name, '.logged_user' );
        $I->see( $name );

        return $user;
    }

    public static function logout($I){
        $I->click( '#log_out_button' );
        $I->amOnPage( route('auth.login') );
    }

}
