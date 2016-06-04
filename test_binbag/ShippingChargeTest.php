<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Gloudemans\Shoppingcart\Facades\Cart as Cart;
use App\Http\Controllers\HelperController as HelperController;
use App\Product as Product;
use App\Option as Option;
use App\ShippingOption as ShippingOption;

class ShippingChargeTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */

    // test ordering something that weights more than the topmost shipping bracker
    public function testOrderBeyondShippingOptionWeight(){
        $this->assertTrue(false);
    }

    // test that internal (Norway) shipping within different weights is calculated and charged properly
    public function testShippingWeightBracket()
    {

        // fill cart with lots of same item
        $product = Product::find(1);
        $option  = $product->options()->get()[0];

        $product_weight = $option->weight;
        $quantity = 20; # how many items to add

        $expected_product_price = $option->price * $quantity;
        $expected_weigh = $product_weight * $quantity;
        $expected_shipping_price = 30;

        HelperController::addToCart( $data = [
            'product' => $product,
            'option'  => $option,
            'qty'     => $quantity
        ]);
    
        // create shipping option that is internal (CODE NO) that reflects the heavy shipping

        ShippingOption::create([
            'country_code'  => 'NO', 
            'weight'        => $expected_weigh, 
            'price'         => $expected_shipping_price    
        ]);

        ShippingOption::create([
            'country_code'  => 'NO', 
            'weight'        => $expected_weigh-1, 
            'price'         => $expected_shipping_price-1
        ]);

        ShippingOption::create([
            'country_code'  => 'ALL', 
            'weight'        => $expected_weigh-1, 
            'price'         => $expected_shipping_price-1    
        ]);

        // getting the shipping price should be reflected correctly in the assertion
        $cost = HelperController::calculate_shipping_cost('NO');
        $this->assertTrue ( $cost['shipping'] == $expected_shipping_price );
        $this->assertTrue ( $cost['product'] == $expected_product_price );

        // the shipping/price info should reflect the one in /checkout
        //// this bit here requires selenium so most likely will not be tested
        // $this->visit('/checkout');
        // $this->see('Shipping: ' + $expected_shipping_price);
        // $this->see('Product cost: ' + $expected_product_price);

    }

    // test that the dropdown country selection dynamically changes the correct shipping option
    public function testCheckoutCountryDropdownChangesShipping(){
        $this->assertTrue(false);
    }

    // test that generic shipping within different weights is calculated and charged properly, generic shipment is like an OTHER category
    public function testOtherShippingWeightBracket()
    {
        $this->assertTrue(false);
    }

    // test that shipping option for a predefined country is within the correct bracket/price
    public function testDefinedForeignShippingWeightBracket()
    {
        $this->assertTrue(false);
    }

}
