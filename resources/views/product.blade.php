@extends('master_page')

@section('links')
    <script src="{{ asset('js/script.js') }}" type="text/javascript"></script>
    <link href="{{ asset('css/lightbox.css') }}" rel="stylesheet">


    <link rel="stylesheet" href="{{ asset('css/drop-theme-arrows.css') }}" />
    <script src={{ asset('js/tether.min.js') }}></script>
    <script src={{ asset('js/drop.min.js') }}></script>

@stop

@section('content')

<div class='product col-md-12'>
    <h1>{{$product->title}}</h1>
    <div class='bs-example col-md-12'>
        <a href="{{$product->thumbnail_full}}" data-lightbox="image-1" data-title="My caption">
            <img width=100% id="item-display" src="{{$product->thumbnail_medium}}" alt="{{$product->title}}"/>
        </a>

    </div>
    <div class="col-md-12 bs-example row bg-img related_images">
        @foreach($product->images as $index => $image)
            <div class="col-md-3">
                <a href="{{$image->thumbnail}}?w=150&h=150&fit=crop" data-lightbox="image-{{$index}}" data-title="Related images">
                    <img style="margin:10px;width:100%;" src="{{$image->thumbnail_small}}" alt="Related image for {{$product->title}}"/>
                </a>
            </div>
        @endforeach
    </div>
    <div class="product-price">
        
        <p>
        {{trans('text.price') }}:

        {{$option->price * $rate }}
        </p>
    </div>

    <p>{!! html_entity_decode($product->description) !!}</p>
    {{--<p>{{$product->description}}</p>--}}
    <p>{{ trans('text.ingredients') }}:
        @foreach($product->ingredients as $ingredient)
            <span id="{{$ingredient->slug}}" class="product_ingredient" style="background-color:#E4B7B7;">{{$ingredient->title}}</span>,
            <script>
                var data = render_ingredient('/ingredient/{{$ingredient->slug}}');
                var drop = new Drop({
                    target: document.querySelector('#{{$ingredient->slug}}'),
                    content: data,
                    position: 'bottom left',
                    openOn: 'hover'
                });
            </script>
        @endforeach
    </p>
    <div>
        <form action="" method="POST">
            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
            <select name="option" onchange="this.form.submit()">
            @foreach($product->options as $opt)
                <option {{ ($opt->slug == $option->slug) ? 'selected' : "" }} value="{{$opt->slug}}">{{$opt->title}} {{$opt->price}}</option>
            @endforeach
            </select>
        </form>

    </div>
    <div class="col-md-12 btn-group cart">
        <input class="product_quantity" type="number" name="quantity" value="1"/>
        <button class="btn btn-success add_to_cart"
            onclick="add_to_cart('{{$product->slug}}', '{{$option->slug}}', '{!! route('add_to_cart') !!}')">
                {{ trans('text.add_to_cart') }}
        </button>
    </div>

    <div class='col-md-12'>
        <h2>Related products</h2>
        @foreach($product->related as $related)
        <div class=col-md-4>
            <h4><a href="{!! route('product', [ $related->slug ]) !!}">{{$related->title}}</a></h4>
            <img src="{{$related->thumbnail_small}}">
        </div>
        @endforeach
    </div>
</div>
<script src="{{ asset('js/lightbox.js') }}" type="text/javascript"></script>

@stop
