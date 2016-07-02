
<div class="col-sm-12">
    <div class="wrapper">
        <div class="menu">
            <div id="menu_logo_container">
                <a href="{{route('index')}}">
                    <img class="b-lazy" src="{{ asset('images/loading.gif') }}" data-src="{{asset('images/neven_logo.png')}}" alt="{{trans('text.neven_logo_alt')}}"/>
                    <h1 class="capital nomargin logo_title">neven</h1>
                    <h2 class="nomargin logo_subtitle">{{trans('text.main_logo_subtitle')}}</h2>
                </a>
            </div>
        </div>

        <div class="col-md-12 main_menu">
            <div class="col-md-1"></div>
            <div class="col-sm-6 menu_links">
                <a class="hamburger_toggle toggle-nav glyphicon glyphicon-menu-hamburger" href="#"></a>

                <ul class="menu_links_ul">
                    <li class="active mobieicon_align">
                        <a href="{{ route('index', []) }}"><span title="{{trans('home_icon_that_takes_you_to_the_inex_page')}}" class="menu_icon mobile_only home_mobile_icon" ></span>{{ trans('text.home') }}</a>
                    </li>
                    <li class="dropdown mobieicon_align">
                    
                      <button class="menu_button dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span title="{{ trans('text.categories') }}" class="menu_icon mobile_only categories_mobile_icon" ></span>
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
                        <button class="menu_button dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <span class="menu_icon mobile_only stockist_mobile_icon" title="{{trans('text.stockists')}}" ></span>{{ trans('text.stockists') }}
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="{{route('stockist.index')}}">{{ trans('text.view_stockists')}}</a></li>
                            <li><a href="{{route('stockist')}}">{{ trans('text.become_stockist')}}</a></li>
                        </ul>
                    </li>

                    <li class="mobieicon_align">
                        <a href="{{ route('about') }}"><span class="menu_icon mobile_only aboutus_mobile_icon" title="{{ trans('text.about_us') }}" ></span>{{ trans('text.about_us') }}
                        </a>
                    </li>

                    <li class="mobieicon_align">
                        <a href="{{ route('contact') }}"><span title="{{trans('text.contact')}}" class="menu_icon mobile_only contact_mobile_icon" ></span>{{ trans('text.contact_us') }}
                        </a>
                    </li>

                    <li class="mobieicon_align">
                        <a href="{{route('blog.index')}}"><span title="{{trans('text.blog')}}" class="menu_icon mobile_only blog_mobile_icon" ></span>{{ trans('text.blog') }}
                        </a>
                    </li>

                </ul>    
            </div>
            
            <div class="col-md-3 menu_links">
                <ul class="menu_links_ul align_right mobile_left">
                    <li class="mobieicon_align">
                        <a href="{{ route('cart', []) }}">
                            <img src="{{asset('images/cart.svg')}}" alt="Cart icon" class="cart_icon"/>
                            <span class="cart_count"> <span class="counter_number">{{Cart::count()}}</span></span>
                        </a>

                    </li>
                    @if(App::isLocale('en'))
                        <li class="mobieicon_align">
                            <a href="{{LaravelLocalization::getLocalizedURL('nb') }}"><span tite="{{trans('text.language_icon')}}" class="menu_icon mobile_only language_mobile_icon" ></span><span class="language_icon">NO</span>
                            </a>
                        </li>
                    @else
                        <li class="mobieicon_align">
                            <a href="{{LaravelLocalization::getLocalizedURL('en') }}"><span tite="{{trans('text.language_icon')}}" class="menu_icon mobile_only language_mobile_icon"></span><span class="language_icon">EN</span>
                            </a>
                        </li>
                    @endif
                    
                    @if(!Auth::check())
                        <li class="mobieicon_align">
                            <a title="{{trans('text.sign_in_alt')}}" class="login_button" href="{{ route('auth.login') }}"><span class="menu_icon mobile_only signin_mobile_icon"></span>{{ trans('text.log_in')}}
                            </a>
                        </li>

                        <li class="mobieicon_align">
                            <a href="{{ route('auth.register') }}"><span title="{{ trans('text.sign_up_alt')}}" class="menu_icon mobile_only signup_mobile_icon" >
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