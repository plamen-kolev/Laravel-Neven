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
                            <a class="action_button" href="{{$slide->url}}">{{ trans('text.view_product')}} <img src="images/right_arrow.png"/> </a>
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

<div class="col-md-12 disclaimers">
    <div class="wrapper ">
        <div class="proud">
            <h1 class="white">{{ trans('text.proud_to_be')}}</h1>
            <div class="col-md-12 row-fluid icons">
                <div class="col-md-1"></div>
                <div class="col-md-2 proud_to">
                    <img src="images/proud_cold_processed.png" />
                </div>

                <div class="col-md-2 proud_to">
                    <img src="images/proud_no_syntetic.png" />
                </div>

                <div class="col-md-2 proud_to">
                    <img src="images/proud_no_fillers.png" />
                </div>

                <div class="col-md-2 proud_to">
                    <img src="images/produd_vegan.png" />
                </div>

                <div class="col-md-2 proud_to">
                    <img src="images/proud_cruelty_free.png" />
                </div>
                <div class="col-md-1"></div>
            </div>
            <a class="green_link white" href="">{{ trans('text.learn_more')}}</a>
        </div>
    </div> 
    <div class="col md-12 shops">
        
        <h1>{{ trans('text.find_our_products_in_these_stores_as_well')}}</h1>
        <div class="align-center stockists">
            <div class="col-md-1"></div>
            <div class="col-md-2"></div>
            <div class="col-md-2">
                <img src="images/stockist_1.png" />
            </div>
            <div class="col-md-2">
                <img src="images/stockist_2.png" />
            </div>
            <div class="col-md-2">
                <img src="images/stockist_3.png" />
            </div>    
            <div class="col-md-2"></div>
            <div class="col-md-1"></div>
        </div>
    </div> 
    
</div>

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
    <script src="{{ asset('js/script.js') }}" type="text/javascript"></script>
@stop
