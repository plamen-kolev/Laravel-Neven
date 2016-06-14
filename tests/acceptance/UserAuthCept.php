<?php


class UserAuthCept
{
    
    private $name = 'neven';
    private $email = "neven@nevensite.com";
    private $password = 'password';

    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {

        
        $user = common_login($I, $this->name, $this->email);

        # see activation email message
        $I->amOnPage( route('show_cart') );
        $I->see( 'Error: ' + trans('text.send_activation_email_message', ['url' => route('send_activation_email', $user->email) ] ) );

        $I->click( trans('text.checkout') );
        # See empty cart message
        $I->see('Error: ' + trans('text.empty_cart_error'));

        # Add item to cart to avoid empty cart error
        $product = Product::all()->first();
        
        // dd("addtocarthere");

        $I->amOnPage( route('checkout') );

        $I->see(trans('text.activate_account_message'));
    }
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

    $I->click('Register');

    $I->seeRecord('users', ['email' => $email]);
    $user =  \App\User::where('email',$email)->first();

    $active = (bool) $user->active;
    $I->assertFalse($active);

    return $user;
}