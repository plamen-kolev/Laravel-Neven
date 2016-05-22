@extends('master_page')
@section('content')
<div class="col-md-12">
    {!! Form::model($product, array('route' => array('product.store') ) ) !!}
    
        <div class="col-md-12">
            {{ Form::select('category', $options, Input::old('category'), array('placeholder' => 'Category', 'class' => 'generic_input' )) }}
            
        </div>

        <div class="col-md-12">
            {!! Form::text('title_en', Input::old('title_en'), array('placeholder' => 'Product title in English', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-12">
            {!! Form::text('title_nb', Input::old('title_nb'), array('placeholder' => 'Product title in Norwegian', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-12">
            {!! Form::textarea('description_en', Input::old('description_en'), 
                    array(
                        'placeholder' => 'Description in English',
                        'maxlength'=>'5000',
                        'class' => 'generic_input'
                    ) 
                ); 
            !!}
        </div>

        <div class="col-md-12">
            {!! Form::textarea('description_nb', Input::old('description_nb'), 
                    array(
                        'placeholder' => 'Description in Norwegian',
                        'maxlength'=>'5000',
                        'class' => 'generic_input'
                    ) 
                ); 
            !!}
        </div>



        <div class="col-md-12">
            {!! Form::submit('Add product', array('class' => 'generic_submit') )!!}
        </div>

    {!! Form::close() !!}
</div>


@stop