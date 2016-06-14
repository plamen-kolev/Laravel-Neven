<?php

use App\Product as Product;
use App\Http\Controllers\HelperController as HelperController;
use App\User as User;
use Illuminate\Translation\TranslationServiceProvider;

class UserAuthCest{

    public function _before(FunctionalTester $I){
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

   // try logging in wrong password
    public function loggingWithWrongPasswordTest(FunctionalTester $I){
        common_login($I, $this->name, $this->email);
        logout($I);
        $I->fillField('email', $this->email);
        $I->fillField('password', 'wrong_password');
        $I->click( trans('text.login') );
        $I->see( trans('auth.failed') );
    }

   // enter activation code twice as logged in user
    public function visitActivationUrlTwiceAsLoggedUserTest(FunctionalTester $I){
        $user = common_login($I, $this->name, $this->email);
        $I->assertFalse( (bool) $user->active);
        $I->see($this->name, '.logged_user');

        $I->amOnPage( route('account_activation', $user->activation_code ));
        $I->see( trans('text.activation_successful') );
        $I->amOnPage( route('account_activation', $user->activation_code) );
        $I->see( trans('text.activate_user_not_found') );

        $I->assertTrue( (bool) User::find($user->id)->active);

    }

    // enter activation code twice as logged in user
    public function visitActivationUrlTwiceAsGuestTest(FunctionalTester $I){
        $user = common_login($I, $this->name, $this->email);
        $I->assertFalse( (bool) $user->active);
        logout($I);
        $I->see( trans( 'text.log_in' ) , '.login_button');
        $I->amOnPage( route('account_activation', $user->activation_code ));
        $I->see( trans('text.activation_successful') );
        $I->amOnPage( route('account_activation', $user->activation_code) );
        $I->see( trans('text.activate_user_not_found') );

        $I->assertTrue( (bool) User::find($user->id)->active);
    }

    public function userSignsUpSuccessful(FunctionalTester $I){

        $log_path = storage_path('logs/laravel.log');
        
        $user = create_account($I, $this->name, $this->email);
        $activation_code = $user->activation_code;
        $activation_url = "register/verify/{$activation_code}";

        $I->amOnPage(route('account_activation', $activation_code));
        $I->see( trans('text.activation_successful') );

        $I->amOnPage( route('index') );
        $I->see($this->name, '.logged_user');
        $I->dontSee( trans('auth.register') );
        $I->dontSee('text.log_in');

        #Now parse the logs for the email

        $match = preg_grep( "/$activation_code/" , file($log_path));
        # assert single entry was found
        $I->assertTrue( count($match) == 1 );

        # extract activation url
        $match_string = reset($match);
        preg_match('#href="(/\w+/\w+\/\w+)"#', $match_string, $url);
        $url = $url[1];
        
        $active = (bool) \App\User::where('email',$this->email)->first()->active;
        $I->assertTrue( $active );
        $I->amOnPage( route('show_cart') );

        $I->dontSee(trans('text.activate_account_message'));
   }

   public function registeringExistingAccountTest(FunctionalTester $I){

        # legitimate login
        
        $I->amOnPage( route('auth.register') );

        $I->fillField('name', $this->name);
        $I->fillField('email', $this->email);
        $I->fillField('password', 'password');
        $I->fillField('password_confirmation', 'password');

        $I->click('#user_register_button');
        sleep(1);
        $I->click('#log_out_button');
        $I->amOnPage( route('auth.register') );

        # Repeat it, should complain
        
        $I->fillField('name', $this->name);
        $I->fillField('email', $this->email);
        $I->fillField('password', 'password');
        $I->fillField('password_confirmation', 'password');

        $I->click( '#user_register_button' );
        $I->see( trans('validation.unique', [ 'attribute' => 'email']));
   }

   public function blankFieldsTest(FunctionalTester $I){
        $I->amOnPage( route('auth.register') );
        $I->click('#user_register_button');
        $I->see( trans( 'validation.filled', ['attribute'=>'name']) );
        $I->see( trans( 'validation.filled', ['attribute'=>'email']) );
        $I->see( trans( 'validation.filled', ['attribute'=>'password']) );

        $I->fillField('name', 'plamen');
        $I->click('#user_register_button');
        $I->see( trans( 'validation.filled', ['attribute'=>'email']) );
        $I->see( trans( 'validation.filled', ['attribute'=>'password']) );

        $I->fillField('email', 'plamen@email.com');
        $I->click('#user_register_button');
        $I->see( trans( 'validation.filled', ['attribute'=>'password']) );

        $I->fillField('password', 'password');
        $I->click('#user_register_button');
        $I->see( trans('validation.confirmed', ['attribute'=> 'password']));

        $I->fillField('password', 'password');
        $I->fillField('password_confirmation', 'notpassword');
        $I->click('#user_register_button');
        $I->see('The password confirmation does not match.');
   }
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
//        $this->visit('/')->see('text.log_in')->see('text.sign_up');
//        $this->click('#user_register_button');
//
//        $this->type('fakemail.com', 'email');
//        $this->press('#user_register_button');
//        $this->see('The email must be a valid email address.');
//
//        $this->type('foo@mail.com', 'email');
//        $this->type($short_password, 'password');
//        $this->type($short_password, 'password_confirmation');
//        $this->press('#user_register_button');
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
    $I->amOnPage( route('auth.register') );
    $I->fillField('name', $username);
    $I->fillField('email', $email);
    $I->fillField('password', 'password');
    $I->fillField('password_confirmation', 'password');

    $I->click('#user_register_button');

    $I->seeRecord('users', ['email' => $email]);
    $user =  \App\User::where('email',$email)->first();

    $active = (bool) $user->active;
    $I->assertFalse($active);

    return $user;
}