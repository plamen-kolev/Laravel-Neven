<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShoppingCartTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    // add all item options for an item
    public function testAddAllOptionsForItem(){
        $this->assertTrue(false);
    }

    // add different items
    public function testAddDifferentItems(){
        $this->assertTrue(false);
    }

    // remove item(with options) from the product page
    public function testRemoveItemWithMultipleOptionsFromProductPage(){
        $this->assertTrue(false);
    }

    // change product quantity from cart page
    public function testChangeProductQuantityFromCartPage(){
        $this->assertTrue(false);
    }

    // change product quantity for an option in product page
    public function testProductQuantityFromProductPage(){
        $this->assertTrue(false);
    }

    // add items to cart and check that the total price matches
    public function testAddItemsPriceMatches(){
        $this->assertTrue(false);
    }

    // remove all items from the cart
    public function testDestroyCart(){
        $this->assertTrue(false);
    }

    // Test 2 sessions where one will not overwrite/destroy the other
    public function testNormalUsage(){
        $this->assertTrue(false);
    }
}
