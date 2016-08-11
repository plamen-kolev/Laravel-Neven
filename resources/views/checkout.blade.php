@extends('master_page')
@section('content')
<div class="col-md-12">
    <div class="wrapper">
        <div id="hero">
            <div class='layer' data-depth='0.10' data-type='parallax'>
                 <div class="layer-inner layer-generic-back-left pull-left"></div>
                 <div class="layer-inner layer-generic-back-right pull-right"></div>
            </div>
            <div class='layer' data-depth='0.40' data-type='parallax'>
                 <div class="layer-inner layer-generic-front-left pull-left"></div>
                 <div class="layer-inner layer-generic-front-right pull-right"></div>
             </div>
        </div>

        <div class="col-md-3"></div>

        <div class="col-md-6 big_top_margin generic_form">
            <div class="col-md-12">
                <div class="progress_circle_container">
                    <span class="progress_circle"></span>
                    <h1 id="welcome" class="capital center">{{trans('text.welcome')}}</h1>
                    <span style="height:40px;" class="progress_block"></span>
                </div>
            </div>

            @if (!Auth::user())
                <div class="col-md-12">
                    {!! Form::open(array('url' => route('auth.login'), 'method' => 'POST')) !!}
                            {!! Form::text('email', old('email'), array('id' => 'email_input', 'class'=>'generic_input', 'placeholder'=>trans('text.username')) ) !!}
                            {!! Form::password('password', array('class'=>'generic_input', 'placeholder' => trans('text.password')) , old('password')) !!}
                            {!! Form::submit(trans('text.log_in'), array('class'=>'generic_submit capital')) !!}
                    {!! Form::close() !!}
                    <p><a class="green_link" href="{{route('auth.password.reset')}}">{{trans('text.forgotten_password_question')}}</a></p>
                </div>

                <div class="col-md-6">
                    <a class="pull-left capital generic_submit purple" href="{{route('cart')}}">{{trans('text.back_to_cart')}}</a>
                </div>

                <div class="col-md-6">
                    <button  data-toggle="collapse" data-target="#part_1" class="pull-right capital generic_submit" href="">{{trans('text.next')}}</button>
                </div>
            @endif

            <div class="col-md-12 progress_circle_container">
                <span style="height:40px;" class="progress_block"></span>
                <span class="progress_circle"></span>
                <h1 class="capital center">{{trans('text.address_1')}}</h1>
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
                <div class="collapse" id="part_1">
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
                        <?php if(Auth::user()){ $country = Auth::user()->country or $country = 'NO'; } else {$country = 'NO';} ?>
                        {!! Form::select('country', $shipping_countries, $country, ['placeholder' => trans('text.country'),'class' => 'generic_input']) !!}
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-6"><a class="pull-left capital generic_submit purple" href="{{route('cart')}}"> {{trans('text.back_to_cart')}}</a></div>
                        <div class="col-md-6"><span data-toggle="collapse" data-target="#part_2" class="pull-right capital generic_submit pointer" href="">{{trans('text.next')}}</span></div>
                    </div>
                </div>

                <div class="col-md-12 progress_circle_container">
                    <span style="height:40px;" class="progress_block"></span>
                    <span class="progress_circle"></span>
                    <h1 class="capital center">{{trans('text.payment')}}</h1>
                    <span style="height:40px;" class="progress_block"></span>
                </div>
                
                <div class="collapse" id="part_2">

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
                </div>
                @include('partials.cart_content')
                <div class="col-md-12 total_info">
                    <h1 id="shipping_calc">Select a country to calculate shipping</h1>
                </div>
                
                @if (Auth::user())
                    <div class="col-md-12">
                        <label for="remember_me_input">{{trans('text.remember_user_details')}}</label>
                        <input type="checkbox" id="remember_me_input" name="remember_me"/>    
                    </div>
                @endif

            <div class="col-md-12 progress_circle_container">
                {!! Form::submit(trans('text.complete_checkout'), array('name' => 'submiting', 'class' => 'generic_submit big_btn ', 'id' => 'submitform') )!!}    
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>

@stop

@section('scripts')
<script defer type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script defer src="https://checkout.stripe.com/checkout.js"></script>

<script  type="text/javascript">
$( document ).ready(function() {
    @if( $errors->all() )
        $('.collapse').show();
    @endif
    
    @if(Auth::user())
    $('#part_1').show();
    @endif

    // This identifies your website in the createToken call below
    Stripe.setPublishableKey("{{ env('STRIPE_KEY') }}");
    get_total_price();
    $('select[name="country"').change(function(){
        get_total_price()
    });
    
    $('#row6_input').change( function(){get_total_price()} );
})
;
    function get_total_price(){
        var country_code = $('select[name="country"]').find(":selected").val();
        $.ajax({
            dataType: "json",
            url: '/cart/calculate_shipping_cost/' + country_code,
            success: function(cost){
                $('#shipping_calc').html(cost.html);
            }
        });
    }

    jQuery(function($) {
        $('.main_menu').hide();
        $('#payment-form').submit(function(event) {
            $('.collapse').show();
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
            $form.find('.submitform').prop('disabled', false);
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

