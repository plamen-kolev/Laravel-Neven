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
class HelperController extends Controller
{
    public static function upload_image($imate_input, $path, $name){
        $filename  = time() . $name . "." . $image_input->getClientOriginalExtension();
        File::exists(public_path('media')) or File::makeDirectory(public_path('media'));
        File::exists(public_path("media/$path/")) or File::makeDirectory(public_path("media/$path/"));
        $image_locations = array();

        $relative_storage_path = "media/$path/full_$filename";
        $storage_path = public_path($relative_storage_path);
        $image_tmp_path = $image_input->getRealPath();
        Image::make($image_tmp_path)->save($storage_path);
        return $relative_storage_path;

    }

    public static function crop_image($image_input, $path, $name, $sizes){
        $filename  = time() . Str::slug($name) . "." . $image_input->getClientOriginalExtension();
        File::exists(public_path('media')) or File::makeDirectory(public_path('media'));
        File::exists(public_path("media/$path/")) or File::makeDirectory(public_path("media/$path/"));
        $image_locations = array();

        $relative_storage_path = "/media/$path/full_$filename";
        $storage_path = public_path($relative_storage_path);
        $image_tmp_path = $image_input->getRealPath();
        Image::make($image_tmp_path)->save($storage_path);
        array_push($image_locations, $relative_storage_path);

        foreach($sizes as $size){
            $relative_storage_path = "/media/$path/" . $size .  "_$filename";
            $storage_path = public_path($relative_storage_path);
            Image::make($image_tmp_path)->resize($size, null, function ($constraint) {
                                                $constraint->aspectRatio();
                                            })->save($storage_path);
            array_push($image_locations, $relative_storage_path);
        }
        return $image_locations;

    }

    // usage $data=['product'=>productOBJ, 'option'=>optionObj, 'quantity'=>number]
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
            )
        );

        return 1;
    }

    public static function getCurrencySymbol(){
        if( Config::get('app.locale') == 'en' ){
            return '&euro;';
        } else {
            return 'kr';
        }
    }

    public static function getRate(){
        if ( ! env('CONVERT_CURRENCY')) {
            return 1;
        }
        #by default 10 NOK equals to 10*1=10 NOK
        $rate = '1';
        # if language is english, switch to euro converter
        if( Config::get('app.locale') == 'en' ){
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

        $shipping_cost = $option->price;
        $product_cost = Cart::total();
        $total = $shipping_cost + $product_cost;
        $costs = [
            'shipping_lowest'  => HelperController::get_price($option->price) * 100,
            'product_lowest'   => HelperController::get_price(Cart::total())*100,
            
            'shipping'         => HelperController::get_price($option->price),
            'product'          => HelperController::get_price(Cart::total()),

            'total_lowest'     => HelperController::get_price($total) * 100,
            'total'            => HelperController::get_price($total),
            
        ];
        return $costs;
    }


    public static function render_message($message, $alert_type, $alert_text ){
        $data = [
            'message'   => $message,
            'alert_type'=> $alert_type,
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
