@extends('master_page')
@section('content')

<div class="col-md-12">
    <div class="wrapper center">
        <h1>{{$title}}</h1>
    </div>
    
</div>

<div class="col-md-12 gallery_second">
    <div class="wrapper">

        <div class="item_container col-md-12">
            @foreach ($products->chunk(5) as $chunk)
            <div class="row">
                <div class="col-md-1"></div>
                
                @foreach ($chunk as $index=>$product)
                <div class="col-md-2 thumbnail_item">
                    <div class="thumbnail_item_inner" href="">
                        <img src="{{$product->thumbnail_small}}" />
                        <h2 class="thumbnail_title">
                            <a id="product_link_{{$index}}" href="{!! route('product', [ $product->slug ]) !!}">{{$product->title}}</a>
                        </h2>
                        <span class="underliner"></span>
                        <p class="price_label">
                            {{\App\Http\Controllers\HelperController::getCurrencySymbol()}} {{ $product->price()  }}
                        </p>
                        <div class="view_product">
                            <p>
                                <a id="view_product_{{$index}}" href="{!! route('product', [ $product->slug ]) !!}">view product</a>

                            </p>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="col-md-1"></div>
            </div>
            @endforeach

            
        </div>
    </div>

    <div class="col-md-12">
        <div class="wrapper center">
            {{$products->render()}}        
        </div>
    
        
    </div>

</div>


@stop
