@extends('master_page')

@section('links')
    <link href="{{ asset('css/lightbox.css') }}" rel="stylesheet">


    <link rel="stylesheet" href="{{ asset('css/drop-theme-arrows.css') }}" />
    <script src={{ asset('js/tether.min.js') }}></script>
    <script src={{ asset('js/drop.min.js') }}></script>

@stop

@section('content')
<div class="col-sm-12">
    <div class="wrapper">
        <div class="col-sm-5">
            <a href="{{$product->thumbnail_full}}" data-lightbox="image-1" data-title="My caption">
                <img width=100% id="item-display" src="{{$product->thumbnail_medium}}" alt="{{$product->title()}}"/>
            </a>
            <div class="col-sm-12 nopadding">
                @foreach($product->images as $index => $image)
                <div class="col-sm-3">
                    <a href="{{$image->thumbnail_full}}" data-lightbox="image-1" data-title="Related image for {{$product->title()}}">
                        <img style="margin:10px;width:100%;" src="{{$image->thumbnail_small}}" alt="Related image for {{$product->title()}}"/>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-sm-1"></div>
        <div class="col-sm-5">
            <h1>{{$product->title()}}</h1>
            <p class="green_text inline_block">
                {{\App\Http\Controllers\HelperController::getCurrencySymbol()}}
                {{ number_format($option->price * $rate, 2, '.', ',') }}
            </p>
            <div class="col-sm-12 nopadding">
                <div class="col-sm-6 nopadding">
                    <form action="" class="col-md-12" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <select class="col-md-5 input_styler" name="option" onchange="this.form.submit()">
                        @foreach($product->options as $opt)
                            <option 
                                {{ ($opt->slug == $option->slug) ? 'selected' : "" }} value="{{$opt->slug}}">{{$opt->title}} 
                            </option>
                        @endforeach
                        </select>
                        <div class="col-md-1"></div>
                        <input class="col-md-5 input_styler" id="product_quantity" type="number" name="quantity"  value="1"/>
                    </form>
                    
                </div>
                <div class="col-sm-6 nopadding">
                    <button class="input_styler btn btn-success add_to_cart"
                            onclick="add_to_cart('{{$product->slug}}', '{{$option->slug}}', '{!! route('add_to_cart') !!}')">
                                + {{ trans('text.add_to_cart') }}
                    </button>    
                </div>

               <div class="col-sm-12 product_nav nopadding">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#description" class="capital" href="#">{{ trans('text.description')}}</a></li>
                        <li><a class="capital" data-toggle="tab" href="#ingredients" href="#">{{ trans('text.ingredients')}}</a></li>
                        <li><a class="capital" data-toggle="tab" href="#tipsforuse" href="#">{{ trans('text.tips_for_use')}}</a></li>
                        <li><a class="capital" data-toggle="tab" href="#benefits" href="#">{{ trans('text.benefits')}}</a></li>
                    </ul>
               </div>

               <div class="tab-content">
                    <div id="description" class="tab-pane fade in active">
                        <p>{!!$product->description() !!}</p>
                    </div>

                    <div id="ingredients" class="tab-pane fade">
                        <div class="col-md-12">
                        @foreach($product->ingredients as $ingredient)
                            <div id="{{$ingredient->slug}}" class="col-md-4 product_ingredient thumbnail" style="background-color:#E4B7B7;">{{$ingredient->title()}}</div>,
                            <script>
                                var data = render_ingredient("{{route('ingredient.show', $ingredient->slug)}}");
                                var drop = new Drop({
                                    target: document.querySelector('#{{$ingredient->slug}}'),
                                    content: data,
                                    position: 'bottom left',
                                    openOn: 'hover'
                                });
                            </script>
                        @endforeach
                        </div>
                    </div>
                    <div id="tipsforuse" class="tab-pane fade">
                        <p>{!!$product->tips()!!}</p>
                    </div>
                    <div id="benefits" class="tab-pane fade">
                        <p>{!!$product->benefits()!!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="col-md-12">
    <div class="wrapper">
        <div>
            @if(Auth::check())
            <h1 class="capital center">{{ trans('text.write_review')}}</h1>

                <!-- if errors -->
                @if( $errors->all() )
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                          <span class="sr-only">Error:</span>
                            {{ $error }}
                        </div>
                    @endforeach
                @endif

                

                {!! Form::open(array('url' => route("add_review")  )) !!}
                <p>
                    {!! Form::hidden('product', $product->slug) !!}
                    {!! Form::textarea('body', Input::old('body') ,array(
                                        'placeholder'   => trans('text.tell_us'),
                                        'maxlength'     => '5000',
                                        'id'            => 'review_textbox'
                                        )
                                    ) 
                    !!}
                </p>
                <p>
                    {!! Form::select(
                            'Rating', 
                            array(
                                '5' => '5',
                                '4' => '4',
                                '3' => '3',
                                '2' => '2', 
                                '1' => '1'
                            ),
                            Input::old('rating'), ['placeholder' => trans('text.rate_the_product'), 'name'=>'rating']
                        ) 
                    !!}
                </p>
                <p>{!! Form::submit('Submit review') !!}</p>

                {!! Form::close() !!}
            @endif
        </div>
        <div>
            <h1 class="capital center">{{ trans('text.reviews')}}</h1>
            @foreach ($reviews as $review)
            <div class="well">
                <p>
                    @if(Auth::user() == $review->user)
                        {!! Form::open(array('url' => route("delete_review")  )) !!}
                            {!! Form::hidden('id', $review->id) !!}
                            {!! Form::submit('Delete review') !!}

                            {!! Form::close() !!}
                    @endif
                </p>
                <p>Rating: {{$review->rating}}/5</p>
                <p>{!! $review->body !!}</p>    
                <p>By: {{$review->user->name}} On: {{$review->updated_at}}</p>
            </div>
            
            @endforeach

        </div>
    </div>
</div>
<div class="col-md-12 gallery_second">
    <div class="wrapper">
        <h1 class="index_h1_margin capital center">Related products</h1>
        <div class="item_container col-md-12">
            @foreach ($product->related()->get()->chunk(5) as $chunk)
            <div class="row">
                <div class="col-md-1"></div>

                @foreach ($chunk as $index=>$product)
                <div class="col-md-2 thumbnail_item">
                    <div class="thumbnail_item_inner">
                        
                        <img src="{{$product->thumbnail_small}}">
                        <h2 class="thumbnail_title">
                            <a class="" href="{!! route('product.show', [ $product->slug ]) !!}"> {{$product->title()}} </a>
                        </h2>
                        <span class="underliner"></span>
                        <p>{{$product->price()}}</p>
                        <div class="view_product">
                            <p>
                                <a class="" href="{!! route('product.show', [ $product->slug ]) !!}">{{ trans('text.view')}} product</a>
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
</div>

<div class="col-md-12">
    <div class="wrapper">
        
    </div>
    
</div>

@if(Auth::user())
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'review_textbox' );
    </script>

    <script src="{{ asset('js/lightbox.js') }}" type="text/javascript"></script>
@endif
@stop
