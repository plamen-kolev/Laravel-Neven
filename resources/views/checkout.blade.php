@extends('master_page')
@section('content')
<div class="col-md-12">
    <div class="wrapper">
        <div class="col-md-3"></div>

        <div class="col-md-6 big_top_margin">
            <div class="col-md-12">
                <div class="progress_circle_container">
                    <span class="progress_circle"></span>
                    <h1 class="capital center">{{trans('text.welcome')}}</h1>
                    <span style="height:40px;" class="progress_block"></span>
                </div>
            </div>

                @if (!Auth::user())
                <div class="col-md-12">
                    {!! Form::open(array('url' => route('auth.login'), 'method' => 'POST')) !!}
                            {!! Form::text('email', old('email'), array('id' => 'email_input', 'class'=>'generic_input', 'placeholder'=>trans('text.username')) ) !!}
                            {!! Form::password('password', array('class'=>'generic_input', 'placeholder' => trans('text.password')) , old('password')) !!}
                            {!! Form::submit(trans('text.login'), array('class'=>'generic_submit capital')) !!}
                    {!! Form::close() !!}
                    <p><a class="green_link" href="{{route('auth.password.reset')}}">{{trans('text.forgotten_password_question')}}</a></p>
                </div>

                <div class="col-md-6">
                    <a class="pull-left capital generic_submit purple" href="">{{trans('text.back_to_cart')}}</a>
                </div>

                <div class="col-md-6">
                    <a class="pull-right capital generic_submit" href="">{{trans('text.next')}}</a>
                </div>
                @endif
                <div class="col-md-12 progress_circle_container">
                    <span style="height:40px;" class="progress_block"></span>
                    <span class="progress_circle"></span>
                    <h1 class="capital center">{{trans('text.address')}}</h1>
                    <span style="height:40px;" class="progress_block"></span>
                </div>
                
                @if( $errors->all() )
                <div class="col-md-12">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                          <span class="sr-only">{{trans('text.error')}}</span>
                            {{ $error }}
                        </div>
                    @endforeach
                </div>
                @endif
                
                {!! Form::open(array('url' => route('checkout'), 'method' => 'POST', 'id' => 'payment-form', 'class' => 'checkout_form')) !!}
                    @if(!Auth::user())
                        <h2>{{trans('text.checkout_as_guest')}}</h2>
                        <span>{{trans('text.email_used_to_confirm_order')}}</span>
                        <div>
                            {!! Form::text('guest_email', old('guest_email'), array('class'=>'generic_input', 'placeholder'=>trans('text.email')) ) !!}
                        </div>
                    @endif

                        <?php if(Auth::user()){ $name = Auth::user()->name; } else {$name = '';} ?>

                        <div class="col-md-6">{!! Form::text('name', old('name', $name ), array(
                            'class'         => 'generic_input', 
                            'placeholder'   => trans('text.first_name'),
                            'id'            => 'row1_input'
                            )) !!}
                        </div>

                        <?php if(Auth::user()){ $last_name = Auth::user()->last_name; } else {$last_name = '';} ?>

                        <div class="col-md-6">
                        {!! Form::text('surname', old('surname', $last_name)  , array(
                            'class'         => 'generic_input', 
                            'placeholder'   => trans('text.last_name'),
                            'id'            => 'row2_input'
                            )) !!}
                        </div>

                        <?php if(Auth::user()){ $address_1 = Auth::user()->address_1; } else {$address_1 = '';} ?>

                        <div class="col-md-6">
                        {!! Form::text('address_1', old('address_1', $address_1), array(
                            'class'         => 'generic_input', 
                            'placeholder'   => trans('text.address_1'),
                            'id'            => 'row3_input'
                            )) !!}
                        </div>

                        <?php if(Auth::user()){ $address_2 = Auth::user()->address_2; } else {$address_2 = '';} ?>

                        <div class="col-md-6">
                        {!! Form::text('address_2', old('address_2', $address_2), array(
                            'class'         => 'generic_input', 
                            'placeholder'   => trans('text.address_2'),
                            'id'            => 'row4_input'
                            )) !!}
                        </div>

                        <?php if(Auth::user()){ $city = Auth::user()->city; } else {$city = '';} ?>

                        <div class="col-md-6">
                        {!! Form::text('city', old('city', $city), array(
                            'class'         => 'generic_input', 
                            'placeholder'   => trans('text.city'),
                            'id'            => 'row5_input'
                            )) !!}
                        </div>
                       
                        <?php if(Auth::user()){ $post_code = Auth::user()->post_code; } else {$post_code = '';} ?>

                        <div class="col-md-6">
                        {!! Form::text('post_code', old('post_code', $post_code), array(
                            'class'         => 'generic_input', 
                            'placeholder'   => trans('text.post_code'),
                            'id'            => 'row7_input'
                            )) !!}
                        </div>

                        <?php if(Auth::user()){ $phone = Auth::user()->phone; } else {$phone = '';} ?>

                        <div class="col-md-6">
                        {!! Form::text('phone', old('phone', $phone), array(
                            'class'         => 'generic_input', 
                            'placeholder'   => trans('text.phone'),
                            'id'            => 'row8_input'
                            )) !!}
                        </div>
                        
                        <div class="col-md-6">

                        <?php if(Auth::user()){ $country = Auth::user()->country; } else {$country = 'NO';} ?>

                        {!! Form::select('country', $shipping_countries, ($country), ['placeholder' => trans('text.country'),
                                        'class'     => 'generic_input'
                            ]) !!}
                        </div>

                    <div class="col-md-12">
                        <div class="col-md-6">
                            <a class="pull-left capital generic_submit purple" href=""> {{trans('text.back')}}</a>
                            
                        </div>

                        <div class="col-md-6">
                            <a class="pull-right capital generic_submit" href="">{{trans('text.next')}}</a>
                        </div>
                    </div>

                    <div class="col-md-12 progress_circle_container">
                        <span style="height:40px;" class="progress_block"></span>
                        <span class="progress_circle"></span>
                        <h1 class="capital center">{{trans('text.payment')}}</h1>
                        <span style="height:40px;" class="progress_block"></span>
                    </div>

                    
                    <div class="col-md-12 payment_errors" style="display:none;">
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <span class="sr-only">{{trans('text.error')}}</span>
                            <span class="payment-errors"></span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        {!! Form::text('', '', array(
                            'class'         => 'generic_input', 
                            'placeholder'   => trans('text.card_number'),
                            'id'            => 'card_number_input',
                            'data-stripe'   => "number"
                            )) !!}
                    </div>


                    <div class="col-md-6">
                        {!! Form::text('', '', array(
                            'class'         => 'generic_input', 
                            'placeholder'   => trans('text.card_cvc'),
                            'data-stripe'   => 'cvc',
                            'id'            => 'cvc_number_input'
                            )) !!}

                    </div>

                    <div class="col-md-3">
                        {{  Form::selectMonth('month','Expiration', ['data-stripe'=>'exp-month', 
                            'id'    => 'exp_element',
                            'class' => 'generic_input'
                            ])  }}
                    </div>

                    <div class="col-md-3">
                        {{  Form::selectYear('year',date('Y'),date('Y') + 10, date('Y'), [
                            'data-stripe'   =>'exp-year', 
                            'id'            =>'exp_year',
                            'class' => 'generic_input'

                        ] ) }}
                    </div>

                    <div class="col-md-12 total_info">
                        <h1>
                            {{ trans('text.total') }} 
                            {{\App\Http\Controllers\HelperController::getCurrencySymbol()}}
                            {{ number_format(Cart::total() * $rate, 2, '.', ',') }}
                        </h1> 
                        <span id="shipping_calc"></span>

                    </div>
                    
                    @if (Auth::user())
                        <div class="col-md-12">
                            <label for="remember_me_input">{{trans('text.remember_user_details')}}</label>
                            <input type="checkbox" id="remember_me_input" name="remember_me"/>    
                        </div>
                        
                        
                    @endif
                <div class="col-md-12 progress_circle_container">
                    {!! Form::submit(trans('text.complete_checkout'), array('class' => 'generic_submit big_btn ', 'id' => 'submitform') )!!}    
                </div>

        </div>
        <div class="col-md-3"></div>
    </div>
</div>

<script src="https://checkout.stripe.com/checkout.js"></script>
@stop

@section('scripts')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">
        // This identifies your website in the createToken call below
        Stripe.setPublishableKey("{{ env('STRIPE_KEY') }}");
        get_total_price();
        $('select[name="country"').change(function(){
            get_total_price()
        });
        
        $('#row6_input').change( function(){get_total_price()} );

        function get_total_price(){
            var country_code = $('select[name="country"]').find(":selected").val();
            $.ajax({
                dataType: "json",
                url: '/cart/calculate_shipping_cost/' + country_code,
                success: function(cost){
                    // console.log(cost);
                    $('#shipping_calc').html("Shipping: {{\App\Http\Controllers\HelperController::getCurrencySymbol()}}<span id='shipping_cost'>"+ cost.shipping + "</span> Product cost: {{\App\Http\Controllers\HelperController::getCurrencySymbol()}}" + cost.product + " Total: {{\App\Http\Controllers\HelperController::getCurrencySymbol()}}" + cost.total);
                }
            });
        }

        jQuery(function($) {
            $('.main_menu').hide();
            $('#payment-form').submit(function(event) {

                var $form = $(this);

                // Disable the submit button to prevent repeated clicks
                $form.find('.submitform').prop('disabled', true);

                Stripe.card.createToken($form, stripeResponseHandler);

                // Prevent the form from submitting with the default action
                return false;
            });
        });

        function stripeResponseHandler(status, response) {
            var $form = $('#payment-form');

            if (response.error) {
                // Show the errors on the form
                $('.payment_errors').show();
                $form.find('.payment-errors').text(response.error.message);
                $form.find('button').prop('disabled', false);
            } else {
                $('.payment_errors').hide();
                // response contains id and card, which contains additional card details
                var token = response.id;
                // Insert the token into the form so it gets submitted to the server
                $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                // and submit
                $form.get(0).submit();
            }
        };

    </script>
@stop

