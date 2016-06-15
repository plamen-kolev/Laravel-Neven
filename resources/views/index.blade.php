@extends('master_page')

@section('content')

<div class="col-md-12 nomargin nopadding">
    <div class="wrapper">
        <div class="rslides_container">
            <ul id="slider" class="rslides centered-btns centered-btns1">
                @foreach ($slides as $slide)
                <li>
                    <div class="slide_item" style="background-image:url('{{$slide->image}}');">
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
        <h1 class="index_h1_margin capital center">{{ trans('text.special_offers')}}</h1>
        @include('index_products')
    </div>
</div>

@include('proud')

<div class="col-md-12 shops">
    <div class="wrapper">
    
        <h1 class="align-center capital stockists">{{ trans('text.find_our_products_in_these_stores_as_well')}}</h1>
        <div class="">
             @foreach ($stockists->chunk(4) as $chunk)
                <div class="col-md-12">
                    <div class="col-md-2"></div>
                    
                    @foreach($chunk as $stockist)
                        <div class="col-md-2 stockist_icon">
                            <img width=150 src="{{$stockist->thumbnail_full}}" alt="{{$stockist->title}}" />
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
        // nav: true,
        namespace: "centered-btns"
    });

</script>

@stop

@section('links')
    <script src="{{ asset('responsiveslides/responsiveslides.min.js') }}" type="text/javascript"></script>
@stop
