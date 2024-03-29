<?php

use App\Product as Product;
use App\Http\Controllers\HelperController as HelperController;
use App\User as User;
class CheckoutFormCest
{   
    private $name = 'user';
    private $email = "user@neven.com";
    private $password = 'password';
    private $new_password = 'password1';

    public function _before(AcceptanceTester $I)
    {

        $I->amOnPage( '/product' );
        $product = Product::all()->first();
        $I->click( $product->title() );
        $I->fillField('#product_quantity', 2);
        
        $I->click(trans('text.add_to_cart'));
        $I->click('.hamburger_toggle');
        $I->see('2', '.counter_number');
        $I->amOnPage('/checkout');

    }

    public function _after(AcceptanceTester $I){
    }

    // test change country, when order is submitted, should show up as different country in the email
    public  function testCountryDropdown(AcceptanceTester $I){
        $I->selectOption("country", 'Norway');
        sleep(1);
        $I->see( HelperController::get_price(10) , '#shipping_cost');

        $I->selectOption("country", 'Great Britain');
        sleep(1);
        $I->see( HelperController::get_price(30) , '#shipping_cost');

        $I->selectOption("country", 'Other');
        sleep(1);
        $I->see( HelperController::get_price(300), '#shipping_cost');
    }

    // test empty required fields ( valid card details)
    public function testEmptyRequiredFields(AcceptanceTester $I){
        \App\Http\Controllers\HelperController::fill_valid_bank_details_and_submit($I);
        
        # See that we have 7 error fields

        $counter = 5;
        while($counter){
            $error_count = $I->grabMultiple('.alert-danger');
            if(7 == count($error_count)){
               break;
            }
            sleep(1);
            $counter--;
        }


        # now fill every one sequentially and check if the error count goes down
        fill_shipping($I);
        $I->see( trans('text.successful_order') , '#order_successful_message');

    }

    // test empty card field (other payment details valid)
    public function testEmptyCardFields(AcceptanceTester $I){

        \App\Http\Controllers\HelperController::login($I, $this->email, $this->password);
        $I->amOnPage('checkout');
        // \App\Http\Controllers\HelperController::fill_valid_address($I);
        $I->click('#submitform');
        
        sleep(2);
        $I->see('Could not find payment information', '.payment-errors');
        sleep(2);
        
        $I->fillField('#card_number_input', '4242424242424242');
        $I->click('#submitform');

        sleep(2);
        $I->see('Your card\'s expiration month is invalid.');
        sleep(2);

        $I->selectOption("#exp_element", 'December');
        $I->click('#submitform');
        sleep(2);        

        $I->see("Your card's security code is invalid.", '.payment-errors');

        $I->fillField('#cvc_number_input', '123');
        $I->click('#submitform');
        $I->dontSee('.payment-errors');

    }

    // test save details checkbox ticked, email field missing when logged in and checkbox missing
    public function testSaveDetailsForUser(AcceptanceTester $I){
        # First, check that the user details are not filled

        $user = User::where('email', 'user@neven.com')->first();
        $user->address_1    = "";
        $user->address_2    = "";
        $user->city         = "";
        $user->post_code    = "";
        $user->country      = "";
        $user->phone        = "";
        
        $user->save();

        $I->amOnPage( 'checkout' );

        # when not logged in, you will see the email input
        $I->seeElement('#email_input');
        $I->dontSeeElement('#remember_me_input');

        login($I, $this->email, $this->password);
        sleep(2);
        $I->amOnPage( 'checkout' );
        # and not see the checkbox to save details
        # these elements should appear after login
        $I->dontSeeElement('#email_input');
        $I->seeElement('#remember_me_input');
        HelperController::fill_valid_address($I);
        $I->click('#remember_me_input');
        HelperController::fill_valid_bank_details_and_submit($I);

        # check that the user details have been saved

        $I->seeRecord( 'users',
            array(
                'address_1' => 'Address',
                'address_2' => 'Address part2',
                'post_code' => 'Post Code',
                'country'   => 'NO',
                'city'      => 'City',
                'phone'     => '088888',
            )
        );
    }
    // test saved details automatically populated
    public function testDetailsAppearOnForm(AcceptanceTester $I){
        $I->assertTrue(false);
    }
    // test not checking save will not store your details
    public function dontStoreInfo(AcceptanceTester $I){
        # First, check that the user details are not filled
        $user = \App\User::where( 'email', $this->email )->first();
        $user->address_1    = "";
        $user->address_2    = "";
        $user->city         = "";
        $user->post_code    = "";
        $user->country      = "";
        $user->phone        = "";
        $user->save();

        $I->assertEmpty($user->address_1);
        $I->assertEmpty($user->address_2);
        $I->assertEmpty($user->city);
        $I->assertEmpty($user->post_code);
        $I->assertEmpty($user->country);
        $I->assertEmpty($user->phone);

        # when not logged in, you will see the email input

        $I->seeElement('#email_input');
        # and not see the checkbox to save details
        $I->dontSeeElement('#remember_me_input');
        
        $I->amOnPage('checkout');
        # these elements should appear after login
        $I->dontSeeElement('#email_input');
        $I->seeElement('#remember_me_input');
        HelperController::fill_valid_address($I);
        HelperController::fill_valid_bank_details_and_submit($I);


        # check that the user details have been saved
        $I->dontSeeInDatabase( 'users',
            array(
                'address_1' => 'Address',
                'address_2' => 'Address part2',
                'post_code' => 'Post Code',
                'country'   => 'NO',
                'city'      => 'City',
                'phone'     => '088888',
            )
        );
    }
}

function fill_shipping($I){
    $inputs = array(
        [
            'input_id' => 'guest_email',
            'text'     => 'foo@gmail.com',
            'expected_errors' => 6
        ],
        [
            'input_id' => '#row1_input',
            'text'     => 'First name',
            'expected_errors' => 5
        ],
        [
            'input_id' => '#row2_input',
            'text'     => 'Last name',
            'expected_errors' => 4
        ],
        [
            'input_id' => '#row3_input',
            'text'     => 'Address',
            'expected_errors' => 3
        ],
        [
            'input_id' => '#row5_input',
            'text'     => 'City',
            'expected_errors' => 2
        ],
        [
            'input_id' => '#row7_input',
            'text'     => 'Post Code',
            'expected_errors' => 1
        ],
        [
            'input_id' => '#row8_input',
            'text'     => '0886689632',
            'expected_errors' => 0
        ],
    );
    foreach ($inputs as $index=>$input){
        \App\Http\Controllers\HelperController::iterate_and_fill_form($I, $input['input_id'], $input['text'], $input['expected_errors']);
    }
}

function login($I, $email, $password){
   $I->amOnPage('/');
   $I->click('.hamburger_toggle');
   $I->click('.login_button');
   $I->fillField('#login_email_field', $email);
   $I->fillField('#password', $password);

   $I->click('#login_form_button');
}