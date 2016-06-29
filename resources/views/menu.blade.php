
<div class="col-sm-12">
    <div class="wrapper">
         <div class="menu">
            <div id="menu_logo_container">
                <a href="{{route('index')}}"><img src="{{ asset('images/loading.gif') }}" data-src="{{asset('images/neven_logo.png')}}" alt="{{trans('text.neven_logo_alt')}}"/></a>
            </div>
        </div>

        <div class="col-md-12 main_menu">
            <div class="col-md-1"></div>
            <div class="col-sm-6 menu_links">
                <a class="hamburger_toggle toggle-nav glyphicon glyphicon-menu-hamburger" href="#"></a>

                <ul class="menu_links_ul">
                    <li class="active mobieicon_align"><a href="{{ route('index', []) }}"><span class="menu_icon mobile_only" ><img src="/images/home.svg" alt="home icon that takes you to the inex page"/></span>{{ trans('text.home') }}</a></li>
                    <li class="dropdown mobieicon_align">
                    
                      <button class="menu_button dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span class="menu_icon mobile_only" ><img src="/images/categories.svg" alt="Dropdown for categories"/></span>
                        {{ trans('text.categories') }}

                        <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="{{route('product.index')}}">{{trans('text.all_products')}}</a></li>
                        @foreach ($categories as $category)           
                            <li><a href="{{ route('category.show', [$category->slug]) }}"> {{$category->title()}}</a></li>
                        @endforeach
                      </ul>
                    
                    </li>

                    <li class="dropdown mobieicon_align">

                        <button class="menu_button dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <span class="menu_icon mobile_only" ><img src="/images/stockist.svg" alt="Stockists" /></span>{{ trans('text.stockists') }}
                            <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="{{route('stockist.index')}}">{{ trans('text.view_stockists')}}</a></li>
                            <li><a href="{{route('stockist')}}">{{ trans('text.become_stockist')}}</a></li>
                      </ul>
                        
                    </li>
                    <li class="mobieicon_align"><a href="{{ route('about') }}"><span class="menu_icon mobile_only" ><img alt="{{ trans('text.about_us') }}" src="/images/about.svg"/></span>{{ trans('text.about_us') }}</a></li>
                    <li class="mobieicon_align"><a href="{{ route('contact') }}"><span class="menu_icon mobile_only" ><img alt=" {{trans('text.contact')}} " src="/images/contact.svg"/></span>{{ trans('text.contact_us') }}</a></li>
                    <li class="mobieicon_align"><a href="{{route('blog.index')}}"><span class="menu_icon mobile_only" ><img alt="Blog" src="/images/blog.svg"/></span>{{ trans('text.blog') }}</a></li>

                </ul>    
            </div>

            
            <div class="col-md-3 menu_links">
                <ul class="menu_links_ul align_right mobile_left">
                    <li class="mobieicon_align">
                        <a href="{{ route('show_cart', []) }}">
                            <img src="{{asset('images/cart.svg')}}" alt="Cart icon" class="cart_icon"/>
                            <span class="cart_count"> <span class="counter_number">{{Cart::count()}}</span></span>
                        </a>

                    </li>
                    @if(App::isLocale('en'))
                        <li class="mobieicon_align"><a href="{{LaravelLocalization::getLocalizedURL('nb') }}"><span class="menu_icon mobile_only" ><img alt="Language icon" src="/images/languages.svg"/></span><span class="language_icon">NO</span></a></li>
                    @else
                        <li class="mobieicon_align"><a href="{{LaravelLocalization::getLocalizedURL('en') }}"><span class="menu_icon mobile_only" ><img alt="Language icon" src="/images/languages.svg"/></span><span class="language_icon">EN</span></a></li>
                    @endif
                    
                    @if(!Auth::check())

                        <li class="mobieicon_align"><a class="login_button" href="{{ route('auth.login') }}"><span class="menu_icon mobile_only" ><img alt="{{trans('text.sign_in_alt')}}" src="/images/sign-in.svg"/></span>{{ trans('text.log_in')}}</a></li>
                        <li class="mobieicon_align">
                            <a href="{{ route('auth.register') }}"><span class="menu_icon mobile_only" >
                                    <img src="/images/sign-up.svg" alt="{{ trans('text.sign_up_alt')}}"/>
                            </span>{{ trans('text.sign_up')}}</a>
                        </li>

                    @else
                        <li><a id="log_out_button" href="{{ route('auth.logout') }}">{{ trans('text.log_out')}}</a></li>
                        <li class="logged_user">{{ Auth::user()->name }}</li>
                    @endif
                    
                </ul>        
    
            </div>
            <div class="col-md-1 menu_links">
                <form  id="search_form" class="" role="search" method="GET" action="{{ route('search') }}">
                    <input id="search_input" placeholder={{trans('text.search')}} size=10 type="text" name="term" class=""/>
                    <input src="/images/search-nn.svg" id="search_submit" size=1 type="image" class="btn-default" alt="{{trans('text.search_icon_all')}}"/>
                </form>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>