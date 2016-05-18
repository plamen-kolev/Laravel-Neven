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

            <div class="col-md-12">
                
                <div class="col-md-6">
                    {!! Form::open(array('url' => route('auth.login'), 'method' => 'POST')) !!}
                            {!! Form::text('email', old('email'), array('class'=>'generic_input', 'placeholder'=>'Username:') ) !!}
                            {!! Form::password('password', array('class'=>'generic_input', 'placeholder' => 'Password:') , old('password')) !!}
                            {!! Form::submit('Click Me!', array('class'=>'generic_submit')) !!}
                    {!! Form::close() !!}
                    <p><a class="green_text" href="{{route('auth.password.reset')}}">{{trans('text.forgotten_password_question')}}</a></p>
                </div>

                <div class="col-md-6">
                    <h2>{{trans('text.checkout_as_guest')}}</h2>
                    <span>{{trans('text.email_used_to_confirm_order')}}</span>
                        {!! Form::open(array('url' => route('auth.login'), 'method' => 'POST')) !!}
                            {!! Form::text('email', old('email'), array('class'=>'generic_input', 'placeholder'=>'Username:') ) !!}
                        {!! Form::close() !!}
                </div>
                <div class="col-md-6">
                    <a class="pull-left capitalize orange_button" href="">{{trans('text.back_to_cart')}}</a>
                </div>

                <div class="col-md-6">
                    <a class="pull-right capitalize green_button" href="">{{trans('text.next')}}</a>
                </div>

                <div class="col-md-12 progress_circle_container">
                    <span style="height:40px;" class="progress_block"></span>
                    <span class="progress_circle"></span>
                    <h1 class="capital center">{{trans('text.address')}}</h1>
                    <span style="height:40px;" class="progress_block"></span>
                </div>
                <div class="col-md-12">
                    {!! Form::open(array('url' => route('auth.login'), 'method' => 'POST')) !!}
                            <span>{!! Form::text('name', old('name'), array(
                                'class'         => 'generic_input input_half', 
                                'placeholder'   => trans('text.first_name'),
                                'id'            => 'row1_input'
                                )) !!}
                            </span>

                            <span>
                            {!! Form::text('surname', old('surname'), array(
                                'class'         => 'generic_input input_half', 
                                'placeholder'   => trans('text.last_name'),
                                'id'            => 'row2_input'
                                )) !!}
                            </span>

                            <span>
                            {!! Form::text('address_1', old('address_1'), array(
                                'class'         => 'generic_input', 
                                'placeholder'   => trans('text.address_1'),
                                'id'            => 'row3_input'
                                )) !!}
                            </span>

                            <span>
                            {!! Form::text('address_2', old('address_2'), array(
                                'class'         => 'generic_input', 
                                'placeholder'   => trans('text.address_2'),
                                'id'            => 'row4_input'
                                )) !!}
                            </span>

                            <span>
                            {!! Form::text('city', old('city'), array(
                                'class'         => 'generic_input input_half', 
                                'placeholder'   => trans('text.city'),
                                'id'            => 'row5_input'
                                )) !!}
                            </span>
                           
                            <span>
                            {!! Form::text('post_code', old('post_code'), array(
                                'class'         => 'generic_input input_half', 
                                'placeholder'   => trans('text.post_code'),
                                'id'            => 'row7_input'
                                )) !!}
                            </span>

                            <span>
                            {!! Form::text('phone', old('phone'), array(
                                'class'         => 'generic_input input_half', 
                                'placeholder'   => trans('text.phone'),
                                'id'            => 'row8_input'
                                )) !!}
                            </span>
                            
                            <span>
                            {!! Form::select('country', array(
                                "AF" => "Afghanistan",
                                "AX" => "Åland Islands",
                                "AL" => "Albania",
                                "DZ" => "Algeria",
                                "AS" => "American Samoa",
                                "AD" => "Andorra",
                                "AO" => "Angola",
                                "AI" => "Anguilla",
                                "AQ" => "Antarctica",
                                "AG" => "Antigua and Barbuda",
                                "AR" => "Argentina",
                                "AM" => "Armenia",
                                "AW" => "Aruba",
                                "AU" => "Australia",
                                "AT" => "Austria",
                                "AZ" => "Azerbaijan",
                                "BS" => "Bahamas",
                                "BH" => "Bahrain",
                                "BD" => "Bangladesh",
                                "BB" => "Barbados",
                                "BY" => "Belarus",
                                "BE" => "Belgium",
                                "BZ" => "Belize",
                                "BJ" => "Benin",
                                "BM" => "Bermuda",
                                "BT" => "Bhutan",
                                "BO" => "Bolivia, Plurinational State of",
                                "BQ" => "Bonaire, Sint Eustatius and Saba",
                                "BA" => "Bosnia and Herzegovina",
                                "BW" => "Botswana",
                                "BV" => "Bouvet Island",
                                "BR" => "Brazil",
                                "IO" => "British Indian Ocean Territory",
                                "BN" => "Brunei Darussalam",
                                "BG" => "Bulgaria",
                                "BF" => "Burkina Faso",
                                "BI" => "Burundi",
                                "KH" => "Cambodia",
                                "CM" => "Cameroon",
                                "CA" => "Canada",
                                "CV" => "Cape Verde",
                                "KY" => "Cayman Islands",
                                "CF" => "Central African Republic",
                                "TD" => "Chad",
                                "CL" => "Chile",
                                "CN" => "China",
                                "CX" => "Christmas Island",
                                "CC" => "Cocos (Keeling) Islands",
                                "CO" => "Colombia",
                                "KM" => "Comoros",
                                "CG" => "Congo",
                                "CD" => "Congo, the Democratic Republic of the",
                                "CK" => "Cook Islands",
                                "CR" => "Costa Rica",
                                "CI" => "Côte d'Ivoire",
                                "HR" => "Croatia",
                                "CU" => "Cuba",
                                "CW" => "Curaçao",
                                "CY" => "Cyprus",
                                "CZ" => "Czech Republic",
                                "DK" => "Denmark",
                                "DJ" => "Djibouti",
                                "DM" => "Dominica",
                                "DO" => "Dominican Republic",
                                "EC" => "Ecuador",
                                "EG" => "Egypt",
                                "SV" => "El Salvador",
                                "GQ" => "Equatorial Guinea",
                                "ER" => "Eritrea",
                                "EE" => "Estonia",
                                "ET" => "Ethiopia",
                                "FK" => "Falkland Islands (Malvinas)",
                                "FO" => "Faroe Islands",
                                "FJ" => "Fiji",
                                "FI" => "Finland",
                                "FR" => "France",
                                "GF" => "French Guiana",
                                "PF" => "French Polynesia",
                                "TF" => "French Southern Territories",
                                "GA" => "Gabon",
                                "GM" => "Gambia",
                                "GE" => "Georgia",
                                "DE" => "Germany",
                                "GH" => "Ghana",
                                "GI" => "Gibraltar",
                                "GR" => "Greece",
                                "GL" => "Greenland",
                                "GD" => "Grenada",
                                "GP" => "Guadeloupe",
                                "GU" => "Guam",
                                "GT" => "Guatemala",
                                "GG" => "Guernsey",
                                "GN" => "Guinea",
                                "GW" => "Guinea-Bissau",
                                "GY" => "Guyana",
                                "HT" => "Haiti",
                                "HM" => "Heard Island and McDonald Islands",
                                "VA" => "Holy See (Vatican City State)",
                                "HN" => "Honduras",
                                "HK" => "Hong Kong",
                                "HU" => "Hungary",
                                "IS" => "Iceland",
                                "IN" => "India",
                                "ID" => "Indonesia",
                                "IR" => "Iran, Islamic Republic of",
                                "IQ" => "Iraq",
                                "IE" => "Ireland",
                                "IM" => "Isle of Man",
                                "IL" => "Israel",
                                "IT" => "Italy",
                                "JM" => "Jamaica",
                                "JP" => "Japan",
                                "JE" => "Jersey",
                                "JO" => "Jordan",
                                "KZ" => "Kazakhstan",
                                "KE" => "Kenya",
                                "KI" => "Kiribati",
                                "KP" => "Korea, Democratic People's Republic of",
                                "KR" => "Korea, Republic of",
                                "KW" => "Kuwait",
                                "KG" => "Kyrgyzstan",
                                "LA" => "Lao People's Democratic Republic",
                                "LV" => "Latvia",
                                "LB" => "Lebanon",
                                "LS" => "Lesotho",
                                "LR" => "Liberia",
                                "LY" => "Libya",
                                "LI" => "Liechtenstein",
                                "LT" => "Lithuania",
                                "LU" => "Luxembourg",
                                "MO" => "Macao",
                                "MK" => "Macedonia, the former Yugoslav Republic of",
                                "MG" => "Madagascar",
                                "MW" => "Malawi",
                                "MY" => "Malaysia",
                                "MV" => "Maldives",
                                "ML" => "Mali",
                                "MT" => "Malta",
                                "MH" => "Marshall Islands",
                                "MQ" => "Martinique",
                                "MR" => "Mauritania",
                                "MU" => "Mauritius",
                                "YT" => "Mayotte",
                                "MX" => "Mexico",
                                "FM" => "Micronesia, Federated States of",
                                "MD" => "Moldova, Republic of",
                                "MC" => "Monaco",
                                "MN" => "Mongolia",
                                "ME" => "Montenegro",
                                "MS" => "Montserrat",
                                "MA" => "Morocco",
                                "MZ" => "Mozambique",
                                "MM" => "Myanmar",
                                "NA" => "Namibia",
                                "NR" => "Nauru",
                                "NP" => "Nepal",
                                "NL" => "Netherlands",
                                "NC" => "New Caledonia",
                                "NZ" => "New Zealand",
                                "NI" => "Nicaragua",
                                "NE" => "Niger",
                                "NG" => "Nigeria",
                                "NU" => "Niue",
                                "NF" => "Norfolk Island",
                                "MP" => "Northern Mariana Islands",
                                "NO" => "Norway",
                                "OM" => "Oman",
                                "PK" => "Pakistan",
                                "PW" => "Palau",
                                "PS" => "Palestinian Territory, Occupied",
                                "PA" => "Panama",
                                "PG" => "Papua New Guinea",
                                "PY" => "Paraguay",
                                "PE" => "Peru",
                                "PH" => "Philippines",
                                "PN" => "Pitcairn",
                                "PL" => "Poland",
                                "PT" => "Portugal",
                                "PR" => "Puerto Rico",
                                "QA" => "Qatar",
                                "RE" => "Réunion",
                                "RO" => "Romania",
                                "RU" => "Russian Federation",
                                "RW" => "Rwanda",
                                "BL" => "Saint Barthélemy",
                                "SH" => "Saint Helena, Ascension and Tristan da Cunha",
                                "KN" => "Saint Kitts and Nevis",
                                "LC" => "Saint Lucia",
                                "MF" => "Saint Martin (French part)",
                                "PM" => "Saint Pierre and Miquelon",
                                "VC" => "Saint Vincent and the Grenadines",
                                "WS" => "Samoa",
                                "SM" => "San Marino",
                                "ST" => "Sao Tome and Principe",
                                "SA" => "Saudi Arabia",
                                "SN" => "Senegal",
                                "RS" => "Serbia",
                                "SC" => "Seychelles",
                                "SL" => "Sierra Leone",
                                "SG" => "Singapore",
                                "SX" => "Sint Maarten (Dutch part)",
                                "SK" => "Slovakia",
                                "SI" => "Slovenia",
                                "SB" => "Solomon Islands",
                                "SO" => "Somalia",
                                "ZA" => "South Africa",
                                "GS" => "South Georgia and the South Sandwich Islands",
                                "SS" => "South Sudan",
                                "ES" => "Spain",
                                "LK" => "Sri Lanka",
                                "SD" => "Sudan",
                                "SR" => "Suriname",
                                "SJ" => "Svalbard and Jan Mayen",
                                "SZ" => "Swaziland",
                                "SE" => "Sweden",
                                "CH" => "Switzerland",
                                "SY" => "Syrian Arab Republic",
                                "TW" => "Taiwan, Province of China",
                                "TJ" => "Tajikistan",
                                "TZ" => "Tanzania, United Republic of",
                                "TH" => "Thailand",
                                "TL" => "Timor-Leste",
                                "TG" => "Togo",
                                "TK" => "Tokelau",
                                "TO" => "Tonga",
                                "TT" => "Trinidad and Tobago",
                                "TN" => "Tunisia",
                                "TR" => "Turkey",
                                "TM" => "Turkmenistan",
                                "TC" => "Turks and Caicos Islands",
                                "TV" => "Tuvalu",
                                "UG" => "Uganda",
                                "UA" => "Ukraine",
                                "AE" => "United Arab Emirates",
                                "GB" => "United Kingdom",
                                "US" => "United States",
                                "UM" => "United States Minor Outlying Islands",
                                "UY" => "Uruguay",
                                "UZ" => "Uzbekistan",
                                "VU" => "Vanuatu",
                                "VE" => "Venezuela, Bolivarian Republic of",
                                "VN" => "Viet Nam",
                                "VG" => "Virgin Islands, British",
                                "VI" => "Virgin Islands, U.S.",
                                "WF" => "Wallis and Futuna",
                                "EH" => "Western Sahara",
                                "YE" => "Yemen",
                                "ZM" => "Zambia",
                                "ZW" => "Zimbabwe",

                                ), 'NO', ['placeholder' => trans('text.country'),
                                            'class'     => 'generic_input input_half'
                                ]) !!}
                            </span>

                    {!! Form::close() !!}
                </div>
            </div>

            <h1>
                {{ trans('text.total') }} 
                {{\App\Http\Controllers\HelperController::getCurrencySymbol()}}
                {{ number_format(Cart::total() * $rate, 2, '.', ',') }}
            </h1>

            <div class="bd-example" data-example-id="">
                <button id="calculate">Calculate</button>
                <p>Shipping will be: <span id="shipping_calc"></span></p>

                    <fieldset class="form-group">
                        <label for="card_number_input">{{trans('text.card_number')}}</label>
                        <input type="text" class="form-control" id="card_number_input" data-stripe="number"/>
                    </fieldset>

                    <fieldset class="form-group">
                        <label for="cvc_number_input">{{trans('text.card_cvc')}}</label>
                        <input size=3 type="text" class="form-control" id="cvc_number_input" data-stripe="cvc"/>
                    </fieldset>

                    <fieldset class="form-group">
                        <label for="exp_element">{{trans('text.card_expiration')}}</label>
                        {{  Form::selectMonth('month',1, ['data-stripe'=>'exp-month', 'id'=>'exp_element'])  }}
                        {{  Form::selectYear('year',date('Y'),date('Y') + 10, date('Y'), ['data-stripe'=>'exp-year', 'id'=>'exp_year',] ) }}
                    </fieldset>

                    @if (Auth::user())
                        <fieldset class="form-group">
                            <label for="remember_me_input">{{trans('text.remember_user_details')}}</label>
                            <input type="checkbox" id="remember_me_input" name="remember_me"/>
                        </fieldset>
                    @endif
                    <input type="submit" class="btn btn-primary" id="submitform" value="{{trans('text.submit')}}" />
                </form>
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
        $('#row6_input').change( function(){get_total_price()} );

        function get_total_price(){
            var country_code = $('#row6_input').find(":selected").val();
            $.ajax({
                dataType: "json",
                url: '/cart/calculate_shipping_cost/' + country_code,
                success: function(cost){
                    $('#shipping_calc').html("Shipping: {{\App\Http\Controllers\HelperController::getCurrencySymbol()}}<span id='shipping_cost'>"+ cost.shipping + "</span> Product cost: {{\App\Http\Controllers\HelperController::getCurrencySymbol()}}" + cost.product + " Total: {{\App\Http\Controllers\HelperController::getCurrencySymbol()}}" + cost.total);
                }
            });
        }

        jQuery(function($) {
            $('.main_menu').hide();
            $('#payment-form').submit(function(event) {
//                event.preventDefault();
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
                $form.find('.payment-errors').text(response.error.message);
                $form.find('button').prop('disabled', false);
            } else {
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

