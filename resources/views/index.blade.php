@if(!Cookie::get('visited'))
    @include('landing')
@endif

@extends('master_page')

@section('content')

<div class="col-md-12 nomargin  nopadding">
    <div class="wrapper">
        <div class="rslides_container">
            <ul id="slider" class="rslides centered-btns centered-btns1">
                @foreach ($slides as $slide)
                <li>
                    <img class="slide_image" data-src="{{route('image', $slide->image)}}?w=1560&h=480&fit=crop" src="{{ asset('images/loading.gif') }}" alt="{{ $slide->title}}">
                    <div class="slide_item">
                        
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            <h1>{{$slide->description}}</h1>
                            <a class="action_button" href="{{$slide->url}}">{{ trans('text.view_product')}} <img alt="Right arrow" src="images/right_arrow.png"/> </a>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>

    </div>
</div>

<div class="col-md-12 gallery_second">
    <div class="wrapper ">
        <h1 id="products" class="index_h1_margin capital center">{{ trans('text.special_offers')}}</h1>
        @include('index_products')
    </div>
</div>

@include('proud')

<div class="col-md-12 center shops">
    <div class="wrapper">
    
        <h1 class="margin_bottom_100 align-center capital stockists">{{ trans('text.find_our_products_in_these_stores_as_well')}}</h1>
        <div class="">
             @foreach ($stockists->chunk(4) as $chunk)
                <div class="col-md-12">
                    <div class="col-md-2"></div>
                    
                    @foreach($chunk as $stockist)
                        <div class="col-md-2 stockist_icon">
                            <img data-src="{{ route('image',$stockist->thumbnail)}}?w=150&h=150&fit=crop" src="{{ asset('images/loading.gif') }}" width=150 alt="{{$stockist->title}}" />
                        </div>
                    @endforeach
                    
                    <div class="col-md-2"></div>
                </div>
             @endforeach
            
        </div>
    </div>
</div> 

@include('ingredient_origin')

<script type="text/javascript">

    $('#slider').responsiveSlides({
        pager: true,
        speed: 1000,            // Integer: Speed of the transition, in milliseconds
        // nav: true,
        namespace: "centered-btns"
    });

</script>

@stop

@section('links')
    <script src="{{ asset('responsiveslides/responsiveslides.min.js') }}" type="text/javascript"></script>
@stop
