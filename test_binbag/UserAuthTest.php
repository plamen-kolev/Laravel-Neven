<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserAuthTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */

    private $name = 'neven';
    private $email = "neven@nevensite.com";
    private $password = 'password';


    public function common_login(){
        $this->create_account($this->name, $this->email);
//        user is logged in automatically first time, so visit logout page first
        $this->click( trans('text.logout') );

        $this->visit('/login');
        $this->see( trans('text.forgotten_password_question') );
    }
    // try logging in successfully
    public function testLoginSuccessful(){
        $this->common_login();
        $this->type($this->email, 'email');
        $this->type($this->password, 'password');
        $this->press( trans('text.login') );

        $this->seePageIs('/');
        $this->see( $this->name );
    }

    // TODO Try accessing checkout with active account, should not see  Error: Activate your account to proceed to checkout
    public function testActiveAccountNotSeeAlertInCheckout(){
        $this->assertTrue(false);
    }


    // try logging in wrong password
    public function testLoggingWithWrongPassword(){
        $this->common_login();
        $this->type( $this->email , 'email');
        $this->type('wrong_password', 'password');
        $this->press( trans('text.login') );
        $this->see('These credentials do not match our records.');
    }

    // try logging in nonexistent username (email)
    public function testLogingWithNonexistentEmail(){
        $this->common_login();
        $this->type('n@foo.com', 'email');
        $this->type('wrong_password', 'password');
        $this->press( trans('text.login')  );
        $this->see('These credentials do not match our records.');
    }

    // login with blank password
    public function testLoginBlankPassword(){
        $this->assertTrue(false);
    }

    // login with blank username
    public function testLoginBlankUsername(){
        $this->assertTrue(false);
    }

    // go to checkout page with inactive account, try checking out
    public function testCheckoutPageInactiveAccount(){
        $this->create_account($this->name, $this->email);
        $user =  \App\User::where('email',$this->email)->first();
        $active = (bool) $user->active;
        $this->assertFalse($active);
        $this->visit('/checkout');
        $message = trans('text.activate_account_message');

        $this->see($message);
    }

    // go to cart page without having an account, try checking out
    public function testCheckingOutWithoutAccount(){
        $this->visit('cart/show_cart');
        $this->see( trans('text.create_account_to_checkout') );
        $this->click('#checkout_button');
        $this->see( trans('text.create_account') );
    }

    // go to cart page with inactive account, see alert, try activating acount from there
    public function testActivateAccountFromCartPage(){

        $user = $this->create_account($this->name, $this->email);

        $this->visit('cart/show_cart');
        $this->see('Your account is not activated, click');
        $this->click('here');
        $this->assertTrue(false);
    }

    // go to cart page without account, see alert
    public function testVisitCartPageWithoutAccountSeeAlert(){
        $this->assertTrue(false);
    }


    // enter activation code twice
    public function testVisitActivationUrlTwice(){
        $this->assertTrue(false);
    }

    public function testUserSignsUpSuccessful()
    {
        $username = "neven";
        $email = "neven@email.com";

        $user = $this->create_account($username, $email);

        $activation_code = $user->activation_code;
        $activation_url = "register/verify/{$activation_code}";

        $this->visit("/register/verify/{$activation_code}");
        dd($this);
        $this->visit('/');
        $this->see($username);
        $this->dontSee('Register');
        $this->dontSee('Login');

        $active = (bool) \App\User::where('email',$email)->first()->active;
        $this->assertTrue( $active);
        $this->visit('/cart/show_cart');
        $this->dontSee('Your account is not activated');
    }

    public function create_account($username, $email){

    // sanity checks
        $this->check_common();
        $this->type($username, 'name');
        $this->type($email, 'email');
        $this->type('password', 'password');
        $this->type('password', 'password_confirmation');

        ($this->press('Register'));
        $this->seePageIs('/');

        $this->seeInDatabase('users', ['email' => $email]);
        $user =  \App\User::where('email',$email)->first();
        $active = (bool) $user->active;
        $this->assertFalse($active);
        return $user;
    }

    public function registeringExistingAccount(){
        $email = 'neven@email.com';
        $name = 'neven';

        $this->visit('/')->see('Login')->see('Register');
        $this->click('Register');

        $this->type($name, 'name');
        $this->type($email, 'email');
        $this->type('password', 'password');
        $this->type('password', 'password_confirmation');

        ($this->press('Register'));
        $this->seePageIs('/register');
        $this->see('The email has already been taken.');
    }

    public function testBlankFields(){
        $this->check_common();
        $this->press('Register');
        $this->see('The name field is required.')->see('The email field is required.')->see('The password field is required.');

        $this->type('plamen', 'name');
        $this->press('Register');
        $this->see('The email field is required.')->see('The password field is required.');

        $this->type('plamen@email.com', 'email');
        $this->press('Register');
        $this->see('The password field is required.');

        $this->type('password', 'password');
        $this->press('Register');
        $this->see('The password confirmation does not match');

        $this->type('password', 'password');
        $this->type('notpassword', 'password_confirmation');
        $this->press('Register');
        $this->see('The password confirmation does not match.');
    }

    // tests that a user can change password
    public function testChangePassword(){
        $this->assertTrue(false);
    }

    // test forgotten password email
    public function testForgottenpassword(){
        $this->assertTrue();
    }

    public function testInvalidData(){
        $short_password = '12345';
        $this->visit('/')->see('Login')->see('Register');
        $this->click('Register');

        $this->type('fakemail.com', 'email');
        $this->press('Register');
        $this->see('The email must be a valid email address.');

        $this->type('foo@mail.com', 'email');
        $this->type($short_password, 'password');
        $this->type($short_password, 'password_confirmation');
        $this->press('Register');
        $this->see('The password must be at least 6 characters.');
    }

    public function check_common()
    {
        $this->visit('/')->see('Login')->see('Register');
        $this->click('Register');
        $this->see('Name')->see('Email address')->see('Password')->see('Confirm Password')->see('Register');
    }

}