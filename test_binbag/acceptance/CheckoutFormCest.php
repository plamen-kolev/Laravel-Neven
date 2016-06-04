<?php


class CheckoutFormCest
{
    public function _before(WebGuy $I)
    {

        $I->amOnPage('/products/');
        $I->click('//div[@class="row"][1]/div[1]/h1/a');
        $I->click('#product_submit');
        $I->amOnPage('/checkout');
    }

    public function _after(WebGuy $I){
    }

    // test change country, when order is submitted, should show up as different country in the email
    public  function testCountryDropdown(WebGuy $I){
        $I->selectOption("#row6_input", 'Norway');
        sleep(1);
        $I->see( env('SHIPPING_HOME') , '#shipping_cost');

        $I->selectOption("#row6_input", 'United Kingdom');
        sleep(1);
        $I->see( env('SHIPPING_EUROPE') , '#shipping_cost');

        $I->selectOption("#row6_input", 'Afghanistan');
        sleep(1);
        $I->see( env('SHIPPING_WORLD'), '#shipping_cost');
    }

    // test empty required fields ( valid card details)
    public function testEmptyRequiredFields(WebGuy $I){
        \App\Http\Controllers\HelperController::fill_valid_bank_details_and_submit($I);
        $error_count = $I->grabMultiple('.error_label');
        # See that we have 7 error fields
        $I->assertEquals( 7, count($error_count) );

        # now fill every one sequentially and check if the error count goes down
        $inputs = array(
            [
                'input_id' => '#email_input',
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
        foreach ($inputs as $input){
            \App\Http\Controllers\HelperController::iterate_and_fill_form($I, $input['input_id'], $input['text'], $input['expected_errors']);
        }
        $I->see( trans('text.successful_order') , '#order_successful_message');

    }

    // test empty card field (other payment details valid)
    public function testEmptyCardFields(WebGuy $I){

        \App\Http\Controllers\HelperController::login($I);
        $I->amOnPage('checkout');
        \App\Http\Controllers\HelperController::fill_valid_address($I);
        $I->click('#submitform');
        sleep(1);
        $I->selectOption("#exp_element", 'December');

        $I->see('The card number is not a valid credit card number.', '#card_error_field');

        // $card_not_filled = $this->byCssSelector('#card_error_field')->text();
        // $this->assertEquals('The card number is not a valid credit card number.', $card_not_filled);

        $I->fillField('#card_number_input', '4242424242424242');
        $I->click('#submitform');
        sleep(1);


        $I->see("Your card's security code is invalid.", '#card_error_field');

        $I->fillField('#cvc_number_input', '123');
        $I->selectOption("#exp_element", 'January');
        $I->click('#submitform');
        sleep(3);

        // \App\Http\Controllers\HelperController::hangon();
        $I->see("Your card's expiration month is invalid." ,'#card_error_field');
    }

    // test save details checkbox ticked, email field missing when logged in and checkbox missing
    public function testSaveDetailsForUser(WebGuy $I){
        # First, check that the user details are not filled
        $user = \App\User::where( 'email', env('SELENIUM_TEST_USER') . '@neven.com' )->first();
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
        \App\Http\Controllers\HelperController::login($I);
        $I->amOnPage('checkout');
        # these elements should appear after login
        $I->dontSeeElement('#email_input');
        $I->seeElement('#remember_me_input');
        \App\Http\Controllers\HelperController::fill_valid_address($I);
        $I->click('#remember_me_input');
        \App\Http\Controllers\HelperController::fill_valid_bank_details_and_submit($I);


        # check that the user details have been saved
        $I->seeInDatabase( 'users',
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
    public function testDetailsAppearOnForm(WebGuy $I){
        $I->assertTrue(false);
    }
    // test not checking save will not store your details
    public function dontStoreInfo(WebGuy $I){
        # First, check that the user details are not filled
        $user = \App\User::where( 'email', env('SELENIUM_TEST_USER') . '@neven.com' )->first();
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
        \App\Http\Controllers\HelperController::login($I);
        $I->amOnPage('checkout');
        # these elements should appear after login
        $I->dontSeeElement('#email_input');
        $I->seeElement('#remember_me_input');
        \App\Http\Controllers\HelperController::fill_valid_address($I);
        \App\Http\Controllers\HelperController::fill_valid_bank_details_and_submit($I);


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
