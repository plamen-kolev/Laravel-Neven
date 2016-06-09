<div class="col-sm-12 footer">
    <div class="col-sm-12 footer_flowers"> 
        <div class="col-sm-1"></div>
        <div class="col-sm-2">
            <img src="/images/neven2.png" />
        </div>
        <div class="col-sm-6"></div>
        <div class="col-sm-2 hidden_flower">
            <img src="/images/neven1.png" />
        </div>
        <div class="col-sm-1"></div>

    </div>
    <div class="wrapper">
        <div class="col-sm-3">
            <ul>
                <li><a href="">{{ trans('text.home') }}</a></li>
                <li><a href="">{{ trans('text.customer_care') }}</a></li>
                <li><a href="">{{ trans('text.shipping_return') }}</a></li>
                <li><a href="">faq</a></li>
            </ul>
        </div>

        <div class="col-sm-3">
            <ul>
                <p>{{ trans('text.our_friends')}}</p>
                <li><a href="">foo</a></li>
                <li><a href="">bar</a></li>
                <li><a href="">baz</a></li>
                <li><a href="">doo</a></li>
            </ul>
        </div>

        <div class="col-sm-3">
            <ul>
                <p>{{ trans('text.find_us_on')}}</p>
                <li><a href="">facebook</a></li>
                <li><a href="">instagram</a></li>
                <li><a href="">twitter</a></li>
                <li><a href="">pinterest</a></li>
            </ul>
        </div>

        <div class="col-sm-3">
            <p>{{ trans('text.never_miss_out_our_update')}}</p>
            @if( $errors && $errors->subscribe_email->first('subscribe_email') )
                <div class="col-md-12">
                    <div class="alert alert-danger" role="alert">
                      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                      <span class="sr-only">Error:</span>
                        {{$errors->subscribe_email->first('subscribe_email') }}
                    </div>
                </div>
            @endif

            <form class="footer_email_form" method="POST" action="{{route('subscribe')}}">
                {{ csrf_field() }}
                <input class="generic_input" value="{{old('subscribe_email')}}" placeholder="{{trans('text.email')}}" name="subscribe_email" type="email" id="footer_email_input" />
                <input class="green_button" type="submit" value="{{trans('text.subscribe')}}" />
            </form>
            <ul style="padding:0px;margin-top:20px;">
                <li><a href="">{{ trans('text.log_in')}}</a></li>
                <li><a href="">{{ trans('text.featured_products')}}</a></li>
            </ul>
        </div>


        <div class="icons_and_trade">
            <p>Copyright &copy; 2016 Neven</p>
            <img src="/images/visa_icon.png" alt="Visa icon"/>
            <img src="/images/mastercard_icon.png" alt="Mastercard icon"/>
            <img src="/images/amex_icon.png" alt="American express icon"/>
            <img src="/images/paypal_icon.png" alt="Paypal icon"/>
        </div>

    </div>
</div>