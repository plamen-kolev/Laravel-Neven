<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LocalizationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    // Check that the menu categories will change language
    public function testMenuCategoryTranslation()
    {
        $this->assertTrue(false);
    }

    // test product title, description will change language
    public function testProductTextTranslation()
    {
        $this->assertTrue(false);
    }

    // test product price changes
    public function testProductPriceChangesOnTranslation()
    {
        $this->assertTrue(false);
    }

    // test ingredients change language
    public function testIngredientsChangeOnTranslation()
    {
        $this->assertTrue(false);
    }

    // test menu and login page for language change
    public function testMenuAndLoginChangeOnTranslation()
    {
        $this->assertTrue(false);
    }

    // test shopping cart change currency and symbol
    public function testCartCurrencySymbolOnTranslation()
    {
        $this->assertTrue(false);
    }
}
