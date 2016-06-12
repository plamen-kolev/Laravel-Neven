
<div class="col-sm-12">
    <div class="wrapper">
         <div class="menu">
            <div id="menu_logo_container">
                <a href="{{route('index')}}"><img src="/images/neven_logo.png" alt="Neven logo"/></a>
            </div>
        </div>

        <div class="col-md-12 main_menu">
            <div class="col-sm-6 menu_links">
                <a class="hamburger_toggle toggle-nav glyphicon glyphicon-menu-hamburger" href="#"></a>

                <ul class="menu_links_ul">
                    <li class="active mobieicon_align"><a href="{{ route('index', []) }}"><span class="menu_icon mobile_only" ><img src="/images/home.svg" alt="home icon that takes you to the inex page"/></span>{{ trans('text.home') }}</a></li>

                    <li class="dropdown mobieicon_align">
                        <a href="{{route('product.index')}}" class="dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false"><span class="menu_icon mobile_only" ><img src="/images/categories.svg" alt="Dropdown for categories"/></span>{{ trans('text.categories') }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                        @foreach ($categories as $category)           
                            <li><a href="{{ route('category.show', [$category->slug]) }}"> {{$category->title()}}</a></li>
                        @endforeach
                        </ul>
                    </li>
                    <li class="dropdown mobieicon_align">
                        <a href="{{route('stockist.index')}}" class="dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false"><span class="menu_icon mobile_only" ><img src="/images/stockist.svg" alt="Stockists" /></span>{{ trans('text.stockists') }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('stockist.index')}}">{{ trans('text.view_stockists')}}</a></li>
                            <li><a href="{{route('stockist')}}">{{ trans('text.become_stockist')}}</a></li>
                        </ul>
                        
                    </li>
                    <li class="mobieicon_align"><a href="#"><span class="menu_icon mobile_only" ><img alt="About us" src="/images/about.svg"/></span>{{ trans('text.about_us') }}</a></li>
                    <li class="mobieicon_align"><a href="#"><span class="menu_icon mobile_only" ><img alt="Contact page" src="/images/contact.svg"/></span>{{ trans('text.contact_us') }}</a></li>
                    <li class="mobieicon_align"><a href="{{route('blog.index')}}"><span class="menu_icon mobile_only" ><img alt="Blog" src="/images/blog.svg"/></span>{{ trans('text.blog') }}</a></li>

                </ul>    
            </div>

            
            <div class="col-md-4 menu_links">
                <ul class="menu_links_ul align_right mobile_left">
                    <li class="mobieicon_align">
                        <a href="{{ route('show_cart', []) }}">
                            <img alt="Cart icon" class="cart_icon" src="/images/cart.svg"/>
                            <span class="cart_count"> <span class="counter_number">{{Cart::count()}}</span></span>
                        </a>

                    </li>
                    @if(App::isLocale('en'))
                        <li class="mobieicon_align"><a href="{{LaravelLocalization::getLocalizedURL('nb') }}"><span class="menu_icon mobile_only" ><img alt="Language icon" src="/images/languages.svg"/></span><span class="language_icon">NO</span></a></li>
                    @else
                        <li class="mobieicon_align"><a href="{{LaravelLocalization::getLocalizedURL('en') }}"><span class="menu_icon mobile_only" ><img alt="Language icon" src="/images/languages.svg"/></span><span class="language_icon">EN</span></a></li>
                    @endif
                    
                    @if(!Auth::check())
                    <li class="mobieicon_align"><a href="{{ route('auth.login') }}"><span class="menu_icon mobile_only" ><img src="/images/sign-in.svg"/></span>{{ trans('text.log_in')}}</a></li>
                    <li class="mobieicon_align"><a href="{{ route('auth.register') }}"><span class="menu_icon mobile_only" ><img src="/images/sign-up.svg"/></span>{{ trans('text.sign_up')}}</a></li>

                    @else
                    <li><a href="{{ route('auth.logout') }}">{{ trans('text.log_out')}}</a></li>
                    <li>{{ Auth::user()->name }}</li>
                    @endif
                    
                </ul>        
    
            </div>
            <div class="col-md-2 menu_links">
                    <form  id="search_form" class="" role="search" method="GET" action="{{ route('search') }}">
                        <input id="search_input" placeholder={{trans('text.search')}} size=10 type="text" name="term" class=""/>
                        <input src="/images/search-nn.svg" id="search_submit" size=1 type="image" class="btn-default" alt="Search icon"/>
                    </form>
            </div>

        </div>
    </div>
</div>