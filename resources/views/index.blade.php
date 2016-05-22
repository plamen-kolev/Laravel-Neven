@extends('master_page')

@section('content')

<div class="col-md-12">
    <div class="wrapper">
        <div class="rslides_container">
            <ul id="slider" class="rslides centered-btns centered-btns1">
                @foreach ($slides as $slide)
                <li>
                    <div class="slide_item" style="background-image:url('{{$slide->image}}');">
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            <h1>{{$slide->description}}</h1>
                            <a class="action_button" href="{{$slide->url}}">View product <img src="images/right_arrow.png"/> </a>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>

        
    </div>
</div>

<div class="col-md-12 gallery_second">
    <div class="wrapper">
        <h1 class="index_h1_margin capital center">special offers</h1>
        <div class="item_container col-md-12">
            @foreach ($featured_products->chunk(5) as $chunk)
            <div class="row">
                <div class="col-md-1"></div>

                @foreach ($chunk as $index=>$product)
                <div class="col-md-2 thumbnail_item">
                    <div class="thumbnail_item_inner">
                        
                        <img src="{{$product->thumbnail_small}}">
                        <h2 class="thumbnail_title">
                            <a class="" href="{!! route('product.show', [ $product->slug ]) !!}"> {{$product->title}} </a>
                        </h2>
                        <span class="underliner"></span>
                        <p>{{$product->price()}}</p>
                        <div class="view_product">
                            <p>
                                <a class="" href="{!! route('product.show', [ $product->slug ]) !!}">view product</a>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="col-md-1"></div>
            </div>
            @endforeach

            
            <a class="green_link" href="">View all products</a>
        </div>
    </div>
</div>

<div class="col-md-12 disclaimers">
    <div class="wrapper">
        <h1>product to be</h1>
        <div class="align-center">
            <div class="proud_to">
                <img src="images/proud_cold_processed.png" />
            </div>

            <div class="proud_to">
                <img src="images/proud_no_syntetic.png" />
            </div>

            <div class="proud_to">
                <img src="images/proud_no_fillers.png" />
            </div>

            <div class="proud_to">
                <img src="images/produd_vegan.png" />
            </div>

            <div class="proud_to">
                <img src="images/proud_cruelty_free.png" />
            </div>
            <a class="green_link" href="">Learn more</a>
        </div>
        <h1>you can find our products in these stores as well</h1>
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
