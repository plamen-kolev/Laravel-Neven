@extends('master_page')
@section('content')
<div class='col-md-12'>

    <h1>{{ trans('text.products') }}</h1>
    <div class=col-md-12>
        
     @if(!$products)
     nothing found
     @endif


    @foreach ($products->chunk(3) as $chunk)
        <div class='row'>
            @foreach ($chunk as $index=>$product)
            <div class="col-md-4 product_thumbnail">

                <p>Debug {{$product->id}}</p>
                <p>Deebug categoryid {{$product->category_id}}</p>
                <h1><a id="product_link_{{$index}}" href="{!! route('product', [ $product->slug ]) !!}">{{$product->title}}</a></h1>
                <img src="{{$product->thumbnail_small}}" />
                <p>
                {!! str_limit(html_entity_decode($product->description), $limit = 150, $end = '...' ) !!}
{{--                    {{ str_limit($product->description, $limit = 150, $end = '...') }}--}}
                </p>

                <p>{{ trans('text.price') }}: {{$product->price()}}</p>
                @if (! $product->in_stock)
                <div class='btn-danger'>
                    <p>{{ trans('text.out_of_stock') }} !</p>
                </div>
                @else

                @endif

            </div>
            @endforeach
        </div>
    @endforeach
    </div>

    {{$products->render()}}

</div>


@stop
