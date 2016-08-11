<div class="item_container col-md-12 row-fluid gallery_second">
    @foreach ($products->chunk(5) as $chunk)
        <div class="row">
            <div class="col-md-1"></div>

            @foreach ($chunk as $index=>$product)

                <div class="col-md-2 thumbnail_item">
                    
                    <div class="thumbnail_item_inner">

                        @if(Auth::user() && Auth::user()->admin)
                            <span class="pull-right">
                                {{ Form::open(['method' => 'DELETE', 'route' => ['product.destroy', $product->slug]]) }}
                                    {{ Form::submit('Delete', ['class' => 'glyphicon glyphicon-remove danger confirm_delete']) }}
                                {{ Form::close() }}

                                <a class="glyphicon glyphicon-pencil success" href="{{route('product.edit', $product->slug)}}"></a>
                            </span>
                        @endif
                        
                        <a class="" href="{!! route('product.show', [ $product->slug ]) !!}">
                            <img class="b-lazy" data-src="{{ route('image', $product->thumbnail) }}?w=150&h=150&fit=crop" src="{{ asset('images/loading.gif') }}" alt="{{ $product->title() }}">
                        </a>

                        <h2 class="thumbnail_title">
                            <a class="" href="{!! route('product.show', [ $product->slug ]) !!}"> {{$product->title()}} </a>
                        </h2>
                        <span class="underliner"></span>
                        <p class="product_price">
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


    <a class="green_link" href="">{{ trans('text.view_all_products')}}</a>
</div>