<div class="item_container col-md-12 row-fluid">
    @foreach ($products->chunk(5) as $chunk)
        <div class="row">
            <div class="col-md-1"></div>

            @foreach ($chunk as $index=>$product)
                <div class="col-md-2 thumbnail_item">
                    <div class="thumbnail_item_inner">

                        <a class="" href="{!! route('product.show', [ $product->slug ]) !!}">
                            {{--<img src="{{$product->thumbnail_small}}">--}}
                            <img src="{{ $product->thumbnail_small }}">

                        </a>

                        <h2 class="thumbnail_title">
                            <a class="" href="{!! route('product.show', [ $product->slug ]) !!}"> {{$product->title}} </a>
                        </h2>
                        <span class="underliner"></span>
                        <p>
                            {{\App\Http\Controllers\HelperController::getCurrencySymbol()}} {{ number_format($product->price(), 2, '.', ',') }}
                        </p>
                        <div class="view_product">
                            <p>
                                <a class="" href="{!! route('product.show', [ $product->slug ]) !!}">{{ trans('text.view_product')}}</a>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-md-1"></div>
        </div>
    @endforeach


    <a class="green_link" href="">{{ trans('text.fview_all_products')}}</a>
</div>