<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    use DatabaseTransactions;

    // test activate account from checkout page
    public function testActivateAccountFromCheckoutPage()
    {

        $user = User::create([
            'name'   => 'sam',
            'email' =>'sam@sam',
            'activation_code'=>'123',
            'password'=>'$2a$10$AqQvOKVP0yHsGr/HnBAwueyna5J8skzTeNEXYYTdxD7RPWv99SHaG'
        ]);
        $this->visit('/login')->see('Login');
        $this->type('sam@sam', 'email');
        $this->type('password','password');
        $this->press('login_button');
        dd(trans('text.submit') );
        $this->visit('cart/show_cart')->see();

        dd($this);
        $this->assertTrue(true);
    }
}

//require_once ('PHPUnit/Framework/TestCase.php');
//
//use App\User;
//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;
//
//class WebTest extends \PHPUnit_Extensions_Selenium2TestCase
//{
//    /**
//     * A basic test example.
//     *
//     * @return void
//     */
//    use DatabaseTransactions;
//
//    protected function setUp()
//    {
//        $this->setBrowser('firefox');
//        $this->setBrowserUrl('localhost:8000');
//    }
//
//    public function testExample()
//    {
//
//    }
//
//}


//<?php
//
//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;
//use App\User;
//use App\Http\Controllers\EmailController;
//
//class EmailTest extends TestCase
//{
//    use DatabaseTransactions;
//    /**
//     * A basic test example.
//     *
//     * @return void
//     */
//
//    // TODO test clicking on reset email url when checking out
//    public function testActivateAccountFromCheckoutPage(){
//        $this->assertTrue(false);
//    }
//
//    //test checking out sending correct product/oprion/quantity email and stores it corectly in the db
//    public function testCorrectProductOptionQuantityEmailSend(){
//        $this->assertTrue(false);
//    }
//
//    public function testSendConfirmationMail(){
//
//        // test parameters
//        $activation_code = 'test_confirmation_code' . str_random(15);
//        $user_email = "neventestuser@nevenwebsite.com";
//        $user_name = 'nevenuser';
//        $path_to_log = base_path('storage/logs/laravel.log');
//        $account_activation_url = "register/verify/$activation_code";
//
//        $user = new User();
//        $user->name     = $user_name;
//        $user->email    = $user_email;
//        $user->activation_code = $activation_code;
//        $user->active = 0;
//        $user->save();
//
//        $status_code = EmailController::send_confirmation_email($user_email)->getStatusCode();
//        $this->assertEquals($status_code, 200);
//        $log_content = File::get($path_to_log);
//
//        // TODO WRITE CONFIRMATION THAT THE EMAIL CONTAINS THE VERIFICATION URLS
//        print "testSendConfirmationMail needs to confirm mail message";
////        $activation_url_matched = preg_match("#$account_activation_url#", $log_content);
////        $this->assertTrue( (bool) $activation_url_matched );
//
//        // follow the activation url
//        $this->visit($account_activation_url);
//        $activated_user = User::where('email', $user_email)->first();
//        $this->assertTrue( (bool) $activated_user->active);
//
//    }
//}
