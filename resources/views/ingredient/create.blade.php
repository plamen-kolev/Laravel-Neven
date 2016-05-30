@extends('master_page')
@section('content')

@if( $errors->all() )
<div class="col-md-12">
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
          <span class="sr-only">Error:</span>
            {{ $error }}
        </div>
    @endforeach
</div>
@endif

<div class="col-md-12">
    <h1 class="capital center">Create new Ingredient</h1>
    {!! Form::model($ingredient, array('route' => array('ingredient.store'), 'files' => true ) ) !!}
        
        <div class="col-md-12">
            {!! Form::file('thumbnail', Input::old('thumbnail'), array('placeholder' => 'Thumbnail', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-12">
            {!! Form::text('title_en', Input::old('title_en'), array('placeholder' => 'Category title in English', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-12">
            {!! Form::text('title_nb', Input::old('title_nb'), array('placeholder' => 'Category title in Norwegian', 'class' => 'generic_input' )); !!}
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