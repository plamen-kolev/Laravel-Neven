@extends('master_page')
@section('content')
<div class="col-md-12">
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
          <span class="sr-only">Error:</span>
            {{ $error }}
        </div>
    @endforeach
</div>
<div class="col-md-12 create_page">
    <h1 class="capital center">Product</h1>
    <a class=" generic_submit inline_block" style="width:350px; margin-bottom:20px;" target="_blank" href="{{route('category.create')}}">Create category(refresh when done)</a>

    {!! Form::model($product, array('route' => array($route, $product) ,'method' => $method, 'files' => true)  ) !!}
        {{ Form::token() }}
        <div class="col-md-3">
            {{ Form::label('category', 'Category') }}
            {{ Form::select('category', $category_options, Input::old('category', $selected_category), array('placeholder' => 'Category', 'class' => 'generic_input' )) }}
        </div>
        <div class="col-md-9"></div>

        <div class="col-md-12">
            <p>
                {{ Form::label('thumbnail', 'Main image') }}

                @if(! empty($product->thumbnail))
                    <img class="b-lazy" data-src="{{route('image', $product->thumbnail)}}?w=200&fit=crop" src="{{ asset('images/loading.gif') }}"/>
                @endif
                {!! Form::file('thumbnail', Input::old('thumbnail'), array('placeholder' => 'Thumbnail', 'class' => 'generic_input' )); !!}

            </p>

            <p>
                {{ Form::label('hover_image', 'Hover image (defaults to main image if left blank)') }}
                @if(! empty($product->hover_thumbnail))
                    <img class="b-lazy" data-src="{{route('image', $product->hover_thumbnail)}}?w=200&fit=crop" src="{{ asset('images/loading.gif') }}"/>
                @endif
                {!! Form::file('hover_thumbnail', Input::old('hover_thumbnail'), array('placeholder' => 'Hover thumbnail', 'class' => 'generic_input' )); !!}
            </p>

            <p>
                {{ Form::label('images[]', 'More images') }}

                @if($product->images()->get())
                    @foreach($product->images()->get() as $image)
                    <div class="col-sm-3">
                        <img src="{{ route('image', $image->thumbnail)}}?w=100&fit=crop"/>
                    </div>
                    @endforeach
                @endif
            {!! Form::file('images[]', array('multiple'=>true)) !!}
            </p>

        </div>



        <div class="col-md-6">
            {{ Form::label('title_en', 'Title in English') }}
            {!! Form::text('title_en', Input::old('title_en'), array('placeholder' => 'Product title in English', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-6">
            {{ Form::label('title_nb', 'Title in Norwegian') }}
            {!! Form::text('title_nb', Input::old('title_nb'), array('placeholder' => 'Product title in Norwegian', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-12">
            <h2 class="center capital">Product variety <strong>(please enter at least one)</strong></h2>
        </div>

        <table class="multiform product_option" style="width:100%">
            <tr>
                <th>Option title, like 50g or square 50 gr</th>
                <th>Weight in grames</th>
                <th>Price in krona</th>
            </tr>
            @foreach($options as $index=>$option)
            <tr class="replication_protocol">

                <td>
                    <input class="generic_input" type="text" name="option_title[{{$index}}]" value="{{$option->title}}" placeholder="Like 50g, or different shape"/>
                </td>
                <td>
                    <input class="generic_input" type="text" name="option_weight[{{$index}}]" value="{{$option->weight}}" placeholder="Product weight"/>
                </td>
                <td>
                    <input class="generic_input" type="text" name="option_price[{{$index}}]" value="{{$option->price}}" placeholder="Price in krona"/>
                </td>

            </tr>
            @endforeach

            @if(empty($options))
            <tr class="replication_protocol">
                <td>
                    <input class="generic_input" type="text" name="option_title[]" placeholder="Like 50g, or different shape"/>
                </td>
                <td>
                    <input class="generic_input" type="text" name="option_weight[]" placeholder="Product weight"/>
                </td>
                <td>
                    <input class="generic_input" type="text" name="option_price[]" placeholder="Price in krona"/>
                </td>
            </tr>
            @endif

        </table>

        <span class="generic_submit replication_protocol_trigger">Add extra option</span>
        <hr>
        <div class="col-md-6">
            {{ Form::label('tags', 'Tags') }}
            {!! Form::text('tags', Input::old('tags'), array('placeholder' => 'Visible tags(coma separate them)', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-12">
            <p>In stock: {{ Form::checkbox('in_stock', true) }}</p>
            <p>Featured: {{ Form::checkbox('featured') }}</p>

        </div>

        <div class="col-md-6">
            <p>Description in English</p>
            {!! Form::textarea('description_en', Input::old('description_en'),
                    array(
                        'placeholder' => 'Description in English',
                        'maxlength'=>'5000',
                        'class' => 'generic_input'
                    )
                );
            !!}
        </div>

        <div class="col-md-6">
            <p>Description in Norwegian</p>
            {!! Form::textarea('description_nb', Input::old('description_nb'),
                    array(
                        'placeholder' => 'Description in Norwegian',
                        'maxlength'=>'5000',
                        'class' => 'generic_input',

                    )
                )
            !!}
        </div>

        <div class="col-md-6">
            <p>Benefits in English</p>
            {!! Form::textarea('benefits_en', Input::old('benefits_en'),
                    array(
                        'placeholder' => 'Benefits in English',
                        'maxlength'=>'5000',
                        'class' => 'generic_input'
                    )
                )
            !!}
        </div>

        <div class="col-md-6">
            <p>Benefits in Norwegian</p>
            {!! Form::textarea('benefits_nb', Input::old('benefits_nb'),
                    array(
                        'placeholder' => 'Benefits in Norwegian',
                        'maxlength'=>'5000',
                        'class' => 'generic_input'
                    )
                );
            !!}
        </div>

        <div class="col-md-6">
            <p>Tips in English</p>
            {!! Form::textarea('tips_en', Input::old('tips_en'),
                    array(
                        'placeholder' => 'Tips in English',
                        'maxlength'=>'5000',
                        'class' => 'generic_input'
                    )
                )
            !!}
        </div>

        <div class="col-md-6">
            <p>Tips in Norwegian</p>
            {!! Form::textarea('tips_nb', Input::old('tips_nb'),
                    array(
                        'placeholder' => 'Tips in Norwegian',
                        'maxlength'=>'5000',
                        'class' => 'generic_input'
                    )
                )
            !!}
        </div>

        <div class="col-md-12">
            {{ Form::label('ingredients[]', 'Ingredients') }}
            <p><a target="_blank" class="generic_submit" href="{{route('ingredient.create')}}">Create ingredient, refresh when done</a></p>

            {{ Form::select('ingredients[]', $all_ingredients , Input::old('ingredients[]', $related_ingredients), array(
                'class' => 'generic_input more_height',
                'multiple'  => 'multiple',

            )) }}
        </div>


        <div class="col-md-12">
            {!! Form::text('hidden_tags', Input::old('hidden_tags'), array('placeholder' => 'Hidden tags', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-12">
            {{ Form::label('related_products[]', 'Related products') }}
            {{ Form::select('related_products[]', $all_products , Input::old('related_products[]', $related_products), array(
                'class' => 'generic_input more_height',
                'multiple'  => 'multiple',

            )) }}
        </div>

        <div class="col-md-12">
            {!! Form::submit('Submit', array('id' => 'submit_button', 'name' => 'submit_button' , 'class' => 'generic_submit') )!!}
        </div>

    {!! Form::close() !!}
</div>
@stop

@section('scripts')
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
<script>
    $( document ).ready(function() {
        $('textarea').ckeditor();
    });

    $('.replication_protocol_trigger').click(function(){
        $( ".replication_protocol" ).last().clone().appendTo( ".multiform" );
    });

</script>
@stop
