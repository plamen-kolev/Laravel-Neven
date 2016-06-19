<div class="item_container col-md-12 row-fluid">
    @foreach ($products->chunk(5) as $chunk)
        <div class="row">
            <div class="col-md-1"></div>

            @foreach ($chunk as $index=>$product)

                <div class="col-md-2 thumbnail_item">
                    
                    @if(Auth::user() && Auth::user()->admin)
                        {!! Form::model($product, ['method' => 'DELETE', 'route' => array('product.destroy', $product->slug) ] ) !!}
                            {!! Form::submit('delete', array('class' => 'generic_submit') )!!}
                        {{ Form::close() }}

                        {!! Form::model($product, ['method' => 'GET', 'route' => array('product.edit', $product->slug)] ) !!}
                            {!! Form::submit('edit', array('class' => 'generic_submit') )!!}
                        {{ Form::close() }}
                    @endif
                    <div class="thumbnail_item_inner">

                        <a class="" href="{!! route('product.show', [ $product->slug ]) !!}">
                            <img data-src="{{ $product->thumbnail_small }}" src="{{ secure_asset('images/loading.gif') }}" alt="{{ $product->title() }}">
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