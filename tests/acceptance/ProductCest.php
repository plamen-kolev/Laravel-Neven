<?php

use App\Product as Product;
use App\Http\Controllers\HelperController as HelperController;
use Cart;

class ProductCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function addMultipleOptionToCart(AcceptanceTester $I)
    {
        
        Cart::destroy();
        $product = Product::find(1);
        $product_two = Product::find(2);

        
        $I->amOnPage( 'product/' . $product->slug  );
        $I->click('#add_to_cart_button');
        sleep(1);
        $I->see( trans('text.item_added') );
        sleep(2);
        $I->dontSee( trans('text.item_added') );

        $I->click('.hamburger_toggle');

        $I->see(1,'.counter_number');


        $option = $I->grabTextFrom('.option_dropdown option:nth-child(2)');
        $I->selectOption(".option_dropdown", $option);
        $I->fillField('#product_quantity', 2);

        $I->click('#add_to_cart_button');
        $I->click('.hamburger_toggle');
        $I->see(3,'.counter_number');

        # add different product's option for good measure
        $I->amOnPage( 'product/' . $product_two->slug  );
        $I->fillField('#product_quantity', 2);
        $I->click('#add_to_cart_button');
        $I->click('.hamburger_toggle');
        
        $I->see(5, '.counter_number');
    }
}
