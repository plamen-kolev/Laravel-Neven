
<div class="col-sm-12">
    <div class="wrapper">
        <div class="menu">
            <div id="menu_logo_container">
                <a href="{{route('index')}}"><img src="/images/neven_logo.png"/></a>
            </div>
        </div>

        <div class="col-md-12 main_menu">
            <div class="col-md-1"></div>
            <div class="col-sm-5 menu_links">
                <ul>

                    <li class="active"><a href="{{ route('index', []) }}">{{ trans('text.home') }}</a></li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ trans('text.categories') }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                        <li><a href="{{ route('product.index',[] ) }}">{{ trans('text.all_categories') }}</a></li>
                        @foreach ($categories as $category)           
                            <li><a href="{{ route('category.show', [$category->slug]) }}"> {{$category->id}} {{$category->title}}</a></li>
                        @endforeach
                        </ul>
                    </li>
                    <li><a href="{{route('stockist')}}">{{ trans('text.become_stockist')}}</a></li>
                    <li><a href="#">{{ trans('text.about_us') }}</a></li>
                    <li><a href="#">{{ trans('text.contact_us') }}</a></li>
                    <li><a href="{{route('blog.index')}}">{{ trans('text.blog') }}</a></li>

                </ul>    
            </div>

            <div class="col-md-2">
                    <form  id="search_form" class="" role="search" method="GET" action="{{ route('search') }}">
                        <input id="search_input" placeholder={{trans('text.search')}} size=10 type="text" name="term" class="" placeholder="{{ trans('text.search') }}">
                        <input src="/images/search_icon.png" id="search_submit" size=1 type="image" value="{{trans('text.search')}}" class="btn-default">
                    </form>
            </div>
            <div class="col-md-3 menu_links">
                <ul>
                    @if(App::isLocale('en'))
                        <li><a href="{{LaravelLocalization::getLocalizedURL('nb') }}"><img src="/images/no.png"></a></li>
                    @else
                        <li><a href="{{LaravelLocalization::getLocalizedURL('en') }}"><img src="/images/en_gb.png"></a></li>
                    @endif
                    <!-- <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ trans('text.languages') }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li>
                                <a rel="alternate" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
                                    {{{ $properties['native'] }}}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li> -->
                    @if(!Auth::check())
                    <li><a href="{{ route('auth.login') }}">{{ trans('text.log_in')}}</a></li>
                    <li><a href="{{ route('auth.register') }}">{{ trans('text.sign_up')}}</a></li>

                    @else
                    <li><a href="{{ route('auth.logout') }}">{{ trans('text.log_out')}}</a></li>
                    <li>{{ Auth::user()->name }}</li>
                    @endif
                    <li>
                        <a href="{{ route('show_cart', []) }}">
                            <img class="cart_icon" src="/images/cart.png"/>
                            <span class="cart_count"> {{Cart::count()}} </span>
                        </a>

                    </li>
                </ul>        
    
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>