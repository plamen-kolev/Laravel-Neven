<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PaymentTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */


    // test checkout on empty cart
    public function testCheckoutEmptyCart(){
        Cart::destroy();
        $this->visit('/checkout');
        $this->see( trans('text.empty_cart_error') );
    }

    // Test paypal valid payment
    public function testPaypalSuccessfulPayment(){
        $this->assertTrue(false);
    }

    // 4242424242424242    Visa
    public function testVisaSuccessful(){
        $this->assertTrue(false);
    }

    // 4000056655665556    Visa (debit)
    public function testVisaDebitSuccessful(){
        $this->assertTrue(false);
    }

    // 5555555555554444    MasterCard
    public function testMasterCardSuccessful(){
        $this->assertTrue(false);
    }

    // 5200828282828210    MasterCard (debit)
    public function testMasterCardDebitSuccessful(){
        $this->assertTrue(false);
    }

    // 5105105105105100    MasterCard (prepaid)
    public function testMasterCardPrepaidSuccessful(){
        $this->assertTrue(false);
    }

    // 378282246310005 American Express
    public function testAmericanExpressSuccessful(){
        $this->assertTrue(false);
    }

    // 6011111111111117    Discover
    public function testDiscoverSuccessful(){
        $this->assertTrue(false);
    }

    // 30569309025904  Diners Club
    public function testDinersClubSuccessful(){
        $this->assertTrue(false);
    }

    // 3530111333300000    JCB
    public function testJCBSuccessful(){
        $this->assertTrue(false);
    }

    // 4000000000000341    Attaching this card to a Customer object will succeed, but attempts to charge the customer will fail.
    public function testFailWhenCVCEntered(){
        $this->assertTrue(false);
    }

    // 4000000000000002    Charge will be declined with a card_declined code.
    public function testCardDeclinedCode(){
        $this->assertTrue(false);
    }

    // 4100000000000019    Charge will be declined with a card_declined code and a fraudulent reason.
    public function testCardDeclinedCodeFraudReason(){
        $this->assertTrue(false);
    }

    // 4000000000000127(also 2 digit cvc)    Charge will be declined with an incorrect_cvc code.
    public function testIncorrectCvcCode(){
        $this->assertTrue(false);
    }

    // 4000000000000069    Charge will be declined with an expired_card code.
    public function testExpiredCard(){
        $this->assertTrue(false);
    }

    // 4000000000000119    Charge will be declined with a processing_error code.
    public function testProcessingError(){
        $this->assertTrue(false);
    }

    // incorrect_number: Use a number that fails the Luhn check, e.g. 4242424242424241.
    public function testIncorrectNumber(){
        $this->assertTrue(false);
    }

    // invalid_expiry_month: Use an invalid month e.g. 13.
    public function testInvalidExpiryMonths(){
        $this->assertTrue(false);
    }

    // invalid_expiry_year: Use a year in the past e.g. 1970.
    public function testInvalidExpiryYears(){
        $this->assertTrue(false);
    }


    // TODO not pri
    // winning_evidence    The dispute will be closed and marked as won. Your account will be credited the amount of the charge and related fees.
    // losing_evidence The dispute will be closed and marked as lost. Your account will not be credited.1
    // 4000000000000259    With default account settings, charge will succeed, only to be disputed.
    // 4000000000000077    Charge will succeed and funds will be added directly to your available balance (bypassing your pending balance).
    // 4000000000000093    Charge will succeed and domestic pricing will be used (other test cards use international pricing). This card is only significant in countries with split pricing.
        // 4000000000000010    With default account settings, charge will succeed but address_line1_check and address_zip_check will both fail.
    // 4000000000000028    With default account settings, charge will succeed but address_line1_check will fail.
    // 4000000000000036    With default account settings, charge will succeed but address_zip_check will fail.
    // 4000000000000044    With default account settings, charge will succeed but address_zip_check and address_line1_check will both be unavailable.
    // 4000000000000101    With default account settings, charge will succeed unless a CVC is entered, in which case cvc_check will fail and the charge will be declined.
}
