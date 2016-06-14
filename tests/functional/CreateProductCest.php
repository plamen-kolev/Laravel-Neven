<?php

use App\Product as Product;
use App\Category as Category;
use App\Ingredient as Ingredient;
use Illuminate\Foundation\Auth\User as User;

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

        $title_en = 'Title in english';
        $title_nb = 'Title in norwegian';
        $product_price_krona = 100;
        $description_en = 'Description en';
        $benefits_en = "Benefits en";
        $tips_en = 'Tips in english';

        # fill create product form
        $I->selectOption('category', $category->id);
        $I->attachFile('thumbnail', 'test_main.jpg');
        $I->attachFile('images[]', 'test_more1.jpg');

        $I->fillField('tags', 'hello, i, am, a, tag');
        $I->fillField('hidden_tags', 'lorem, ipsum, dolor');

        $I->fillField('title_en', $title_en);
        $I->fillField('title_nb', $title_nb);

        $I->fillField('option_title[]', 'Option');
        $I->fillField('option_weight[]', '10');
        $I->fillField('option_price[]', $product_price_krona);

        $I->fillField('description_en', $description_en);
        $I->fillField('description_nb', 'Description nb');

        $I->fillField('benefits_en', $benefits_en);
        $I->fillField('benefits_nb', 'Benefits nb');

        $I->fillField('tips_en', $tips_en);
        $I->fillField('tips_nb', 'Tips nb');

        $I->selectOption('ingredients[]', $ingredient->id);
        $I->selectOption('related_products[]', $related_product->id);

        $I->click('Submit', '#submit_button');

        $I->dontSee('CREATE NEW PRODUCT');
        $I->see('Creating ' . $title_en . ' was successful');
        $user = new User();
        $user->name = 'lel';
        $user->email = "lel@neven.com";
        $user->password = '$2a$10$AqQvOKVP0yHsGr/HnBAwueyna5J8skzTeNEXYYTdxD7RPWv99SHaG';
        $user->save();

        $I->seeRecord('products', array('title_en' => $title_en) );

        # NOW LETS TEST DATA ACCESS

        $I->amOnPage('/nb/product/' . \Illuminate\Support\Str::slug($title_en));

        $I->see($title_nb, '.product_title');
        $I->see($product_price_krona, '#option_price');

        $I->amOnPage('/en/product/' . \Illuminate\Support\Str::slug($title_en));
        $I->see($title_en, '.product_title');

        $rate = Swap::quote('NOK/EUR')->getValue() or 1;
        $eur_price = $product_price_krona * $rate;
        $I->see($eur_price, '#option_price');


        $I->see($description_en);
        $I->see($ingredient->title_en);
        $I->see($benefits_en);
        $I->see($tips_en);
        # see related product
        $I->see($related_product->title_en);
    }
}
