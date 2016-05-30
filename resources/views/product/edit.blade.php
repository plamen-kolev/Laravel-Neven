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
    <div class="col-md-12">
        <h1 class="capital center">Update Product</h1>


        <h2>Add images</h2>
        <h2>Add options</h2>
        <h3>Add related products</h3>

        {!! Form::model($product, array('route' => array('product.update', $product->slug) , 'files' => true)  ) !!}

        <div class="col-md-12">
            {{ Form::select('category', $category_options, Input::old('category', $product->category), array( 'class' => 'generic_input' )) }}

        </div>
        <div class="col-md-12">

            <img src="{{$product->thumbnail_small}}" alt=""/>
            {!! Form::file('thumbnail', Input::old('thumbnail'), array('placeholder' => 'Thumbnail', 'class' => 'generic_input' )) !!}
        </div>

        <div class="col-md-6">
            {!! Form::text('title_en', Input::old('title_en', $en_translation->title), array('placeholder' => 'Product title in English', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-6">
            {!! Form::text('title_nb', Input::old('title_nb', $nb_translation->title), array('placeholder' => 'Product title in Norwegian', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-12">
            <!-- <input type="checkbox" name="vehicle" value="Bike"> -->
            <p>In stock: {{ Form::checkbox('in_stock', 1, true) }}</p>

        </div>

        <div class="col-md-6">
            <p>Description in English</p>
            {!! Form::textarea('description_en', Input::old('description_en', $en_translation->description),
                    array(
                        'placeholder' => 'Description in English',
                        'maxlength'=>'5000',
                        'class' => 'generic_input',
                    ) 
                )
            !!}
        </div>

        <div class="col-md-6">
            <p>Description in Norwegian</p>
            {!! Form::textarea('description_nb', Input::old('description_nb', $nb_translation->description),
                    array(
                        'placeholder' => 'Description in Norwegian',
                        'maxlength'=>'5000',
                        'class' => 'generic_input'
                    ) 
                )
            !!}
        </div>

        <div class="col-md-6">
            <p>Benefits in English</p>
            {!! Form::textarea('benefits_en', Input::old('benefits_en', $en_translation->benefits),
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
            {!! Form::textarea('benefits_nb', Input::old('benefits_nb', $nb_translation->benefits),
                    array(
                        'placeholder' => 'Benefits in Norwegian',
                        'maxlength'=>'5000',
                        'class' => 'generic_input'
                    ) 
                )
            !!}
        </div>

        <div class="col-md-6">
            <p>Tips in English</p>
            {!! Form::textarea('tips_en', Input::old('tips_en', $en_translation->tips),
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
            {!! Form::textarea('tips_nb', Input::old('tips_nb', $nb_translation->tips),
                    array(
                        'placeholder' => 'Tips in Norwegian',
                        'maxlength'=>'5000',
                        'class' => 'generic_input'
                    ) 
                )
            !!}
        </div>

        <div class="col-md-6">
            {!! Form::text('tags', Input::old('tags'), array('placeholder' => 'Visible tags(coma separate them)', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-6">
            {!! Form::text('hidden_tags', Input::old('hidden_tags'), array('placeholder' => 'Hidden tags', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-12">
            {{ Form::label('related_products[]', 'Related products') }}

            {{ Form::select('related_products[]', $all_products, $related_products, array(
                'placeholder' => 'Related products(control+click to assign',
                'class' => 'generic_input more_height',
                'multiple'  => 'multiple',

            )) }}
        </div>

        <div class="col-md-12">
            {!! Form::submit('Add product', array('class' => 'generic_submit') )!!}
        </div>

        {!! Form::close() !!}
    </div>

    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
    <script>

        $( document ).ready(function() {

            $('textarea').ckeditor({toolbar : 'simple', customConfig : 'config.js',});
        });

    </script>


@stop