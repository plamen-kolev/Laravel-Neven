<?php

namespace App\Http\Controllers;

use Config;
use Illuminate\Http\Request;
use Symfony\Component\Console\Helper\Helper;
use View;
use App\Http\Requests;
use Swap;
use File;
use Image;
use App\ShippingOption as ShippingOption;
use Cart;
class HelperController extends Controller
{

    public static function cropImage($image_input, $path, $name, $sizes){
        $filename  = time() . $name . "." . $image_input->getClientOriginalExtension();

        File::exists(storage_path('app/public/images/')) or File::makeDirectory(storage_path('app/public/images/'));
        File::exists(storage_path("app/public/images/$path/")) or File::makeDirectory(storage_path("app/public/images/$path/"));
        $image_locations = array();

        $storage_path = storage_path("app/public/images/$path/full_$filename");
        $image_tmp_path = $image_input->getRealPath();
        Image::make($image_tmp_path)->save($storage_path);
        array_push($image_locations, $storage_path);

        foreach($sizes as $size){
            $storage_path = storage_path("app/public/images/$path/" . $size .  "_$filename");
            Image::make($image_tmp_path)->resize($size, null, function ($constraint) {
                                                $constraint->aspectRatio();
                                            })->save($storage_path);
            array_push($image_locations, $storage_path);
        }
        return $image_locations;

    }

    // usage $data=['product'=>productOBJ, 'option'=>optionObj, 'quantity'=>number]
    public static function addToCart($data){
        // calculate weight
        $product = $data['product'];
        $option  = $data['option'];

        $total_weight = 0;
        for ($i=0; $i < $data['qty']; $i++) {
            $total_weight += $option->weight;
        }
        $found = Cart::search(   array('id' => $product->id)    );
        if($found){
            Cart::update($found[0], $data['qty']);
        } else {
            Cart::add(array(
                    'id'        => $product->id,
                    'name'      => $product->title,
                    'qty'       => $data['qty'],
                    'price'     => $option->price,
                    'options'=> array(
                        'option'    => $option,
                        'thumbnail_small' => $product->thumbnail_small,
                        'weight'    => $total_weight
                    )
                )
            );
        }

        return 1;
    }

    public static function getCurrencySymbol(){
        if( Config::get('app.locale') == 'en' ){
            return '&euro;';
        } else {
            return 'kr ';
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
            'shipping_lowest'  => $option->price* 100,
            'product_lowest'   => Cart::total()*100,
            
            'shipping'         => $option->price,
            'product'          => Cart::total(),

            'total_lowest'     => $total * 100,
            'total'            => $total,
            
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
        sleep( 1 );
        $error_count = $I->grabMultiple('.error_label');
        $I->assertEquals( $expected_errors, count($error_count) );
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

    public static function login($I){
       $I->amOnPage('/');
       $I->click('#menu_login_button');
       $I->fillField('#login_email_field', env('SELENIUM_TEST_USER') . "@neven.com");
       $I->fillField('#password', 'password');
       $I->click('#login_button');
    }

}
