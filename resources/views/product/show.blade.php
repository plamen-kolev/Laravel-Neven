@extends('master_page')

@section('links')
    <link href="{{ asset('css/lightbox.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/drop-theme-arrows.css') }}" />
@stop

@section('content')
<div class="col-md-12">
    <div class="wrapper">
        <div class="col-md-1"></div>
        <div class="col-md-5 overflow_protector">
            <a href="{{route('image', $product->thumbnail)}}" data-lightbox="image-1" data-title="{{$product->title()}}">
                    <img class="b-lazy" data-src="{{route('image', $product->thumbnail)}}?w=720&h=450&fit=crop" src="{{ asset('images/loading.gif') }}" alt="{{$product->title()}}"/>
            </a>
            <div class="col-md-12 nopadding">
                @foreach($product->images as $index => $image)
                <div class="col-md-3 nopadding pull-left related_container" style="padding:5px; max-width:150px; overflow:hidden;display:inline-block">
                    <a href="{{route('image', $image->thumbnail)}}" data-lightbox="image-1" data-title="Related image for {{$product->title()}}">
                        <img class="b-lazy" data-src="{{route('image',$image->thumbnail)}}?w=150&h=150&fit=crop"
                            src="{{ asset('images/loading.gif') }}"
                            alt="Related image for {{$product->title()}}"
                        />

                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-5">
            <h1 class='product_title'>{{$product->title()}}</h1>
            <p class="green_text inline_block">
                {{\App\Http\Controllers\HelperController::getCurrencySymbol()}}<span id="option_price">{{ number_format($option->price * $rate, 2, '.', ',') }}</span>
            </p>
            <div class="col-md-12 nopadding">
                <div class="col-md-6 nopadding">
                    <form class="col-md-12 nopadding" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <div class="col-md-8 nopadding_left">
                            <select class="generic_input option_dropdown" name="option" onchange="this.form.submit()">
                            @foreach($product->options as $opt)
                                <option
                                    {{ ($opt->slug == $option->slug) ? 'selected' : "" }} value="{{$opt->slug}}">{{$opt->title}}
                                </option>
                            @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 nopadding_right">
                            <input class="generic_input" id="product_quantity" type="number" name="quantity"  value="1"/>
                        </div>
                    </form>

                </div>
                <div class="col-md-6 nopadding">
                    <div class="product_added_trigger"><p>{{trans('text.item_added')}}</p></div>
                    <button id="add_to_cart_button" class="generic_submit btn btn-success add_to_cart"
                            onclick="add_to_cart('{{$product->slug}}', '{{$option->slug}}', '{!! route('add_to_cart') !!}')">
                                + {{ trans('text.add_to_cart') }}
                    </button>
                </div>

               <div class="col-lg-12 product_nav nopadding">
                    <ul class="nav nav-tabs" id="product_information">
                        <li class="active"><a id="description_toggle" data-toggle="tab" href="#description" class="capital" >{{ trans('text.description')}}</a></li>
                        <li><a id="ingredient_toggle" class="capital" data-toggle="tab" href="#ingredients">{{ trans('text.ingredients')}}</a></li>
                        <li><a id="tips_toggle" class="capital" data-toggle="tab" href="#tipsforuse">{{ trans('text.tips_for_use')}}</a></li>
                        <li><a id="benefits_toggle" class="capital" data-toggle="tab" href="#benefits">{{ trans('text.benefits')}}</a></li>
                    </ul>
               </div>

               <div class="col-md-12 tab-content">
                    <div id="description" class="tab-pane fade in active">
                        <p>{!!$product->description() !!}</p>
                    </div>

                    <div id="ingredients" class="tab-pane fade">
                        <div class="col-md-12">
                        @foreach($product->ingredients as $ingredient)
                            <div class="col-sm-6 ingredient_label_container" id="{{$ingredient->slug}}">
                                <span class="ingredient_tip">
                                    <img alt="{{trans('text.ingredient_tip_alt')}}" src="/images/ingr-tip.svg"/>
                                </span>
                                <div class="ingredients_bg col-md-4 product_ingredient thumbnail" id="{{$ingredient->slug}}">
                                    {{ str_limit($ingredient->title(), $limit = 17, $end = '') }}
                                </div>
                            </div>

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

                <div class="col-md-12">
                    <div class="tag">{{$product->tags}}    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>

</div>
<div class="col-md-12 review_component">
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
        <div class="col-md-12">
            <h1 style="padding-top: 30px;" class="capital center">{{ trans('text.reviews')}}</h1>
            @foreach ($reviews as $review)
            <div class="col-md-1"></div>
            <div class="col-md-10 reviews">
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
            <div class="col-md-1"></div>
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

                        <img class="b-lazy" alt="image" data-src="{{route('image', $product->thumbnail)}}?w=150&h=150&fit=crop" src="{{ asset('images/loading.gif') }}"/>
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
</div>
@stop

@section('scripts')
@if(Auth::user())
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script type="text/javascript">

    CKEDITOR.replace( 'review_textbox' );
</script>
@endif

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(event) {
          @foreach($ingredients as $ingredient)
              var html_content = "<div class='ingr-pop'>";
              html_content +=         "<img class='ingr_pop_img' src='{{route('image', $ingredient->thumbnail)}}?w=200&fit=crop'     alt='{{$ingredient->title() }}'>";
              html_content +=         "<h1>{{$ingredient->title()}}</h1>";
              html_content +=         "{!! $ingredient->description() !!}";
              html_content +=      "</div>";
              console.log(html_content);
              drop = new Drop({
                  target: document.querySelector('#{{$ingredient->slug}}'),
                  position: 'bottom left',
                  openOn: 'click',
                  content: html_content
              });
          @endforeach
            // $.ajax({
            //     dataType: "json",
            //     url: "{{route('product_ingredients', $product->slug) }}",
            //     success: function(data){
            //         for (var i = 0 ; i < data.length; i++) {
            //             var ingredient = data[i];
            //             var html_content =
            //                 '<div class="ingr-pop">'
            //                     + '<img class="ingr_pop_img" src="/images/' + ingredient.thumbnail + '?w=150&h=150&fit=crop" alt="' + ingredient.title_{{App::getLocale()}} + '">'
            //                     + '<h1>' + ingredient.title_{{App::getLocale()}} + '</h1>'
            //                     + '<p>' + ingredient.description_{{App::getLocale()}} + '</p>'
            //                 + '</div>';
            //             console.log("dropping for " + ingredient.slug);
            //             drop = new Drop({
            //                 target: document.querySelector('#' + ingredient.slug),
            //                 position: 'bottom left',
            //                 openOn: 'click',
            //                 content: html_content
            //             });
            //         }
            //     },
            // });


        });
    </script>

@stop
