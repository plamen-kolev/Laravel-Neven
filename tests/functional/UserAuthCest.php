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
    private $new_password = 'password1';

    // try logging in successfully
    public function LoginSuccessfulTest(FunctionalTester $I){
        $I->am('user');
        $I->wantTo('go to register');
        $I->lookForwardTo('getting registered successfully');

        HelperController::common_login($I, $this->name, $this->email, $this->password);

    }

   // try logging in wrong password
    public function loggingWithWrongPasswordTest(FunctionalTester $I){
        HelperController::common_login($I, $this->name, $this->email, $this->password);
        HelperController::logout($I);
        $I->fillField('email', $this->email);
        $I->fillField('password', 'wrong_password');
        $I->click( '#login_form_button' );
        $I->see( trans('auth.failed') );
    }

   // enter activation code twice as logged in user
    public function visitActivationUrlTwiceAsLoggedUserTest(FunctionalTester $I){
        $user = HelperController::common_login($I, $this->name, $this->email, $this->password);
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
        $user = HelperController::common_login($I, $this->name, $this->email, $this->password);
        $I->assertFalse( (bool) $user->active);
        HelperController::logout($I);
        $I->see( trans( 'text.log_in' ) , '.login_button');
        $I->amOnPage( route('account_activation', $user->activation_code ));
        $I->see( trans('text.activation_successful') );
        $I->amOnPage( route('account_activation', $user->activation_code) );
        $I->see( trans('text.activate_user_not_found') );

        $I->assertTrue( (bool) User::find($user->id)->active);
    }

    public function userSignsUpSuccessful(FunctionalTester $I){

        
        $user = HelperController::create_account($I, $this->name, $this->email, $this->password);
        $activation_code = $user->activation_code;
        $activation_url = "register/verify/{$activation_code}";

        $I->amOnPage(route('account_activation', $activation_code));
        $I->see( trans('text.activation_successful') );

        $I->amOnPage( route('index') );
        $I->see($this->name, '.logged_user');
        $I->dontSee( trans('auth.register') );
        $I->dontSee('text.log_in');

        #Now parse the logs for the email

        $log_path = storage_path('logs/laravel.log');
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

   

    // tests that a user can change password
    public function changePasswordTest(FunctionalTester $I){
        $I->amOnPage( route('change_password') );
        $I->seeResponseCodeIs(403);
        $user = HelperController::common_login($I, $this->name, $this->email, $this->password);

        $current_password = $user->password;

        $I->amOnPage( route('change_password') );
        # blank field test
        $I->click('#change_password_button');

        $I->assertEquals( User::find($user->id)->password, $current_password ); # check that no change accoured
        $I->see( trans('validation.required', ['attribute' => 'current password']) );
        $I->see( trans('validation.required', ['attribute' => 'password']) );

        # fill wrong password, see min password requirements and wrong password
        $I->fillField('current_password', '12345');

        $I->click('#change_password_button');
        $I->see( trans('validation.min.string', ['attribute' => 'current password', 'min' => '6']) );
        $I->see( trans('validation.current_password') );

        # now test password confirmation attribute


        $I->fillField('current_password', $this->password);
        $I->fillField('password', $this->new_password);
        $I->click('#change_password_button');

        $I->assertEquals( User::find($user->id)->password, $current_password ); # check that no change accoured
        $I->see( trans('validation.confirmed', ['attribute' => 'password']) );
        $I->dontSee( trans('validation.current_password') );

        # test new password strength requirements

        $I->fillField('current_password', $this->password);
        $I->fillField('password', 'weakp');
        $I->fillField('password_confirmation', 'weakp');
        $I->click('#change_password_button');

        $I->assertEquals( User::find($user->id)->password, $current_password ); # check that no change accoured
        $I->see( trans('validation.min.string', ['attribute' => 'password', 'min' => '6']) );
        $I->see('The password must be at least 6 characters.');
        
        # Test proper password change

        $I->fillField('current_password', $this->password);
        $I->fillField('password', $this->new_password);
        $I->fillField('password_confirmation', $this->new_password);
        $I->click('#change_password_button');

        # check that no change accoured
        $I->see( trans('text.password_change_email_body', ['name' => Auth::user()->name]) );

        $I->assertTrue( Hash::check( $this->new_password , User::find($user->id)->password ));

        # Test email confirmation

        $log_path = storage_path('logs/laravel.log');
        
        $date = date('Y-m-d G:i:s') . '.*\n.*\n.*\n.*\n.*\n.*\n.*\n.*\n\n.*';
        $match = preg_grep( "/$date/" , file($log_path));
        
        # assert single entry was found

        $cmd = "tail " . storage_path('logs/laravel.log') ." | grep 'Hello, " . $this->name . ", your password has been'";
        $output = system($cmd);
        $I->assertEquals( trans('text.password_change_email_body', ['name' => $this->name]), $output );
    }

    public function passwordLongerThan120CharsTest(FunctionalTester $I){
        $user = HelperController::common_login($I, $this->name, $this->email, $this->password);
        $I->amOnPage( route('change_password') );
        
        $out_of_bound_password = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';

        $I->fillField('current_password', $this->password);
        $I->fillField('password', $out_of_bound_password);
        $I->fillField('password_confirmation', $out_of_bound_password);
        $I->click('#change_password_button');

        $I->see( trans('validation.max.string', ['attribute' => 'password', 'max' => 120]) );

    }

    // test forgotten password email
    public function forgottenpasswordTest(FunctionalTester $I){
        $user = HelperController::common_login($I, $this->name, $this->email, $this->password);
        HelperController::logout($I);
        $I->amOnPage( route('auth.password.reset') );
        $I->fillField('.email_form', 'nonregistered email');
        $I->click( trans('text.send_password_reset_link') );
        $I->see( 'The email must be a valid email address.' );

        $I->fillField('.email_form', 'some@gibberish.com');
        $I->click( trans('text.send_password_reset_link') );
        $I->see( trans('passwords.user') );

        $I->fillField('.email_form', $this->email);
        $I->click( trans('text.send_password_reset_link') );
        $I->see( trans('passwords.sent') );

        # check email
        $token = DB::table('password_resets')->where('email', $this->email)->first()->token;
        $log_path = storage_path('logs/laravel.log');
        $match = preg_grep( "/$token/" , file($log_path));
        $match = implode('|', $match);

        preg_match('#href="(.*)"#', $match, $url);
        $url = $url[1];

        # follow email
        $I->amOnPage($url);

        $I->see( trans('text.reset_password') );
        $I->click( '.reset_password_button' );
        $I->see( trans('validation.filled', ['attribute' => 'password']) );
        $I->fillField('password', $this->new_password);
        $I->click( '.reset_password_button' );
        $I->see( trans('validation.confirmed', ['attribute' => 'password']) );
        
        # change password
        $I->fillField('password', $this->new_password);
        $I->fillField('password_confirmation', $this->new_password);
        $I->click( '.reset_password_button' );

        # see index page
        
        $I->click('.logged_user');
    }

    public function invalidDataTest(FunctionalTester $I){
        $short_password = '12345';
        $I->amOnPage( route('auth.register') );
        $I->click('#user_register_button');

        $I->fillField('email', 'fakemail.com');
        $I->click('#user_register_button');
        $I->see('The email must be a valid email address.');

        $I->fillField('email', 'foo@mail.com');
        $I->fillField('password', $short_password);
        $I->fillField('password_confirmation', $short_password);
        $I->click('#user_register_button');
        $I->see('The password must be at least 6 characters.');
    }
}