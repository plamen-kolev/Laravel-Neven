
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
                <a class="hamburger_toggle toggle-nav glyphicon glyphicon-menu-hamburger" href="#"></a>

                <ul class="menu_links_ul">
                    <li class="active"><a href="{{ route('index', []) }}"><span class="glyphicon glyphicon-home mobile_only menu_icon"></span>{{ trans('text.home') }}</a></li>

                    <li class="dropdown">
                        <a href="{{route('product.index')}}" class="dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-tag mobile_only menu_icon"></span>{{ trans('text.categories') }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                        @foreach ($categories as $category)           
                            <li><a href="{{ route('category.show', [$category->slug]) }}"> {{$category->title()}}</a></li>
                        @endforeach
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="{{route('stockist.index')}}" class="dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-leaf mobile_only menu_icon"></span>{{ trans('text.stockists') }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('stockist.index')}}"></span>{{ trans('text.view_stockists')}}</a></li>
                            <li><a href="{{route('stockist')}}">{{ trans('text.become_stockist')}}</a></li>
                        </ul>
                        
                    </li>
                    <li><a href="#"><span class="glyphicon glyphicon-heart mobile_only menu_icon"></span>{{ trans('text.about_us') }}</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-send mobile_only menu_icon"></span>{{ trans('text.contact_us') }}</a></li>
                    <li><a href="{{route('blog.index')}}"><span class="glyphicon glyphicon-comment mobile_only menu_icon"></span>{{ trans('text.blog') }}</a></li>

                </ul>    
            </div>

            
            <div class="col-md-3 menu_links">
                <ul class="menu_links_ul align_right mobile_left">
                    <li>
                        <a href="{{ route('show_cart', []) }}">
                            <img class="cart_icon" src="/images/cart.png"/>
                            <span class="cart_count"> <span class="counter_number">{{Cart::count()}}</span></span>
                        </a>

                    </li>
                    @if(App::isLocale('en'))
                        <li><a href="{{LaravelLocalization::getLocalizedURL('nb') }}"><span class="glyphicon glyphicon-globe mobile_only menu_icon"></span><span class="language_icon">NO</span></a></li>
                    @else
                        <li><a href="{{LaravelLocalization::getLocalizedURL('en') }}"><span class="glyphicon glyphicon-globe mobile_only menu_icon"></span><span class="language_icon">EN</span></a></li>
                    @endif
                    
                    @if(!Auth::check())
                    <li><a href="{{ route('auth.login') }}"><span class="glyphicon glyphicon-circle-arrow-right mobile_only menu_icon"></span>{{ trans('text.log_in')}}</a></li>
                    <li><a href="{{ route('auth.register') }}"><span class="glyphicon glyphicon-plus-sign mobile_only menu_icon"></span>{{ trans('text.sign_up')}}</a></li>

                    @else
                    <li><a href="{{ route('auth.logout') }}">{{ trans('text.log_out')}}</a></li>
                    <li>{{ Auth::user()->name }}</li>
                    @endif
                    
                </ul>        
    
            </div>
            <div class="col-md-2 menu_links">
                    <form  id="search_form" class="" role="search" method="GET" action="{{ route('search') }}">
                        <input id="search_input" placeholder={{trans('text.search')}} size=10 type="text" name="term" class="" placeholder="{{ trans('text.search') }}">
                        <input src="/images/search_icon.png" id="search_submit" size=1 type="image" value="{{trans('text.search')}}" class="btn-default">
                    </form>
            </div>

            <div class="col-md-1"></div>
        </div>
    </div>
</div>