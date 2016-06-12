<?php

use App\Product as Product;
use App\Http\Controllers\HelperController as HelperController;

class UserAuthCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    private $name = 'neven';
    private $email = "neven@nevensite.com";
    private $password = 'password';

    // try logging in successfully
    public function LoginSuccessfulTest(FunctionalTester $I){
        $I->am('user');
        $I->wantTo('go to register');
        $I->lookForwardTo('getting registered successfully');

        common_login($I, $this->name, $this->email);

    }


    public function inactiveAccountSeeAlertInCheckoutTest($I){
        $I->am('user');
        $I->wantTo('get activate account notification, forbidden access to checkout');

        $user = common_login($I, $this->name, $this->email);

        $I->amOnPage( route('show_cart') );
        $I->see( 'Error: ' + trans('text.send_activation_email_message', ['url' => route('send_activation_email', $user->email) ] ) );

        $I->click( trans('text.checkout') );
        $I->see('Error: ' + trans('text.empty_cart_error'));

        $product = Product::all()->first();

        HelperController::add_to_cart($data = [
            'product'   => $product,
            'option'    => $product->options()->first(),
            'qty'  => 1
        ]);

        $I->amOnPage( route('checkout') );

        $I->see(trans('text.activate_account_message'));

        // TODO follow activation link
        // TODO check log for email
        // TODO follow email activation link
        // TODO check if text.activate_account message is gone and checkout is allowed

    }

//    // try logging in wrong password
    public function loggingWithWrongPasswordTest(FunctionalTester $I){
        common_login($I, $this->name, $this->email);
        logout($I);
        $I->fillField('email', $this->email);
        $I->fillField('password', 'wrong_password');
        $I->click( trans('text.login') );
        $I->see( trans('auth.failed') );
    }

//    // enter activation code twice
    public function visitActivationUrlTwiceTest(FunctionalTester $I){
        $user = common_login($I, $this->name, $this->email);


        $I->amOnPage( route('account_activation', $user->activation_code ));
        $I->see( trans('text.activation_successful') );
        $I->amOnPage( route('account_activation', $user->activation_code) );
        $I->see( trans('text.activate_user_not_found') );

    }
//
//    public function testUserSignsUpSuccessful()
//    {
//        $username = "neven";
//        $email = "neven@email.com";
//
//        $user = $this->create_account($username, $email);
//
//        $activation_code = $user->activation_code;
//        $activation_url = "register/verify/{$activation_code}";
//
//        $this->visit("/register/verify/{$activation_code}");
//        dd($this);
//        $this->visit('/');
//        $this->see($username);
//        $this->dontSee('Register');
//        $this->dontSee('Login');
//
//        $active = (bool) \App\User::where('email',$email)->first()->active;
//        $this->assertTrue( $active);
//        $this->visit('/cart/show_cart');
//        $this->dontSee('Your account is not activated');
//    }
//
//
//
//    public function registeringExistingAccount(){
//        $email = 'neven@email.com';
//        $name = 'neven';
//
//        $this->visit('/')->see('Login')->see('Register');
//        $this->click('Register');
//
//        $this->type($name, 'name');
//        $this->type($email, 'email');
//        $this->type('password', 'password');
//        $this->type('password', 'password_confirmation');
//
//        ($this->press('Register'));
//        $this->seePageIs('/register');
//        $this->see('The email has already been taken.');
//    }
//
//    public function testBlankFields(){
//        $this->check_common();
//        $this->press('Register');
//        $this->see('The name field is required.')->see('The email field is required.')->see('The password field is required.');
//
//        $this->type('plamen', 'name');
//        $this->press('Register');
//        $this->see('The email field is required.')->see('The password field is required.');
//
//        $this->type('plamen@email.com', 'email');
//        $this->press('Register');
//        $this->see('The password field is required.');
//
//        $this->type('password', 'password');
//        $this->press('Register');
//        $this->see('The password confirmation does not match');
//
//        $this->type('password', 'password');
//        $this->type('notpassword', 'password_confirmation');
//        $this->press('Register');
//        $this->see('The password confirmation does not match.');
//    }
//
//    // tests that a user can change password
//    public function testChangePassword(){
//        $this->assertTrue(false);
//    }
//
//    // test forgotten password email
//    public function testForgottenpassword(){
//        $this->assertTrue();
//    }
//
//    public function testInvalidData(){
//        $short_password = '12345';
//        $this->visit('/')->see('Login')->see('Register');
//        $this->click('Register');
//
//        $this->type('fakemail.com', 'email');
//        $this->press('Register');
//        $this->see('The email must be a valid email address.');
//
//        $this->type('foo@mail.com', 'email');
//        $this->type($short_password, 'password');
//        $this->type($short_password, 'password_confirmation');
//        $this->press('Register');
//        $this->see('The password must be at least 6 characters.');
//    }

}

//  ============   HELPER CONTROLLER

function common_login($I, $name, $email){

    $user = create_account($I, $name, $email);
//        user is logged in automatically first time, so visit logout page first
    $I->click( trans('text.log_out') );

    $I->amOnPage( route('auth.login') );
    $I->see( trans('text.forgotten_password_question') );
    $I->fillField('email', $email);
    $I->fillField('password', 'password');
    $I->click( trans('text.login') );

    $I->see( $name );

    return $user;
}

function logout($I){
    $I->click( trans('text.log_out') );
    $I->amOnPage( route('auth.login') );
}

function create_account($I, $username, $email){
//        dd($email);
    // sanity checks
    $I->amOnPage( route('auth.register') );
    $I->fillField('name', $username);
    $I->fillField('email', $email);
    $I->fillField('password', 'password');
    $I->fillField('password_confirmation', 'password');

    $I->click('Register');

    $I->seeRecord('users', ['email' => $email]);
    $user =  \App\User::where('email',$email)->first();

    $active = (bool) $user->active;
    $I->assertFalse($active);

    return $user;
}