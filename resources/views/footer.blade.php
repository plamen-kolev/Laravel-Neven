<div class="col-sm-12 footer">
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
                <p>our friends</p>
                <li><a href="">foo</a></li>
                <li><a href="">bar</a></li>
                <li><a href="">baz</a></li>
                <li><a href="">doo</a></li>
            </ul>
        </div>

        <div class="col-sm-3">
            <ul>
                <p>find us on</p>
                <li><a href="">facebook</a></li>
                <li><a href="">instagram</a></li>
                <li><a href="">twitter</a></li>
                <li><a href="">pinterest</a></li>
            </ul>
        </div>

        <div class="col-sm-3">
            <p>Never miss out our update :)</p>
            @if( $errors->subscribe_email->first('subscribe_email') )
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
                <input value="{{old('subscribe_email')}}" placeholder="{{trans('text.email')}}" name="subscribe_email" type="email" id="footer_email_input" />
                <input class="green_button" type="submit" value="{{trans('text.subscribe')}}" />
            </form>
            <ul style="padding:0px;margin-top:20px;">
                <li><a href="">log in</a></li>
                <li><a href="">feature products</a></li>
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