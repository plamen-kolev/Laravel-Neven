<?php

use App\Product as Product;
use App\Category as Category;
use App\Ingredient as Ingredient;

class CreateProductCest
{
    public function _before(FunctionalTester $I)
    {

    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function accessForbiddenNormalUserTest(FunctionalTester $I)
    {
        $I->am('user');
        $I->wantTo('go to create page');
        $I->lookForwardTo('get 403, access forbidden');

        $I->amOnPage('/login');
        $I->fillField('email','user@neven.com');
        $I->fillField('password','password');
        $I->click('Login');

        $I->amOnPage( route('product.create') );
        $I->see(403);
    }

    public function createProductAsAdminUserTest(FunctionalTester $I){
        # login part
        $I->am('user');
        $I->wantTo('go to create page');
        $I->lookForwardTo('get 403, access forbidden');

        $I->amOnPage('/login');
        $I->fillField('email','selenium@neven.com');
        $I->fillField('password','password');
        $I->click('Login');

        $I->amOnPage( route('product.create') );
        $I->see('CREATE NEW PRODUCT');

        $category = Category::all()->first();
        $ingredient = Ingredient::all()->first();
        $related_product = Product::all()->first();

        # fill create product form
        $I->selectOption('category', $category->id);
        $I->attachFile('thumbnail', 'test_main.jpg');
        $I->attachFile('images[]', 'test_more1.jpg');

        $I->fillField('tags', 'hello, i, am, a, tag');
        $I->fillField('hidden_tags', 'lorem, ipsum, dolor');

        $I->fillField('title_en', 'Title in english');
        $I->fillField('title_nb', 'Title in norwegian');

        $I->fillField('option_title[]', 'Option');
        $I->fillField('option_weight[]', '10');
        $I->fillField('option_price[]', '100');

        $I->fillField('description_en', 'Description en');
        $I->fillField('description_nb', 'Description nb');

        $I->fillField('benefits_en', 'Benefits en');
        $I->fillField('benefits_nb', 'Benefits nb');

        $I->fillField('tips_en', 'Tips en');
        $I->fillField('tips_nb', 'Tips nb');

        $I->selectOption('ingredients[]', $ingredient->id);
        $I->selectOption('related_products[]', $related_product->id);

        $I->click('Submit', '#submit_button');

        $I->seeInDatabase();

    }
}
