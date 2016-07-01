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
    <h1 class="capital center">Edit category</h1>
    {!! Form::model($category, array('route' => array('category.store'), 'method' => 'PUT', 'files' => true ) ) !!}
        
        <div class="col-md-12">
            {{ Form::label('thumbnail', 'Thumbnail') }}

            {!! Form::file('thumbnail', Input::old('thumbnail', $category->thumbnail), array('placeholder' => 'Thumbnail', 'class' => 'generic_input' )); !!}
            <div><img src="{{$category->thumbnail_small}}" alt=""/></div>
        </div>

        <div class="col-md-12">
            {{ Form::label('title_en', 'Title in English') }}
            {!! Form::text('title_en', Input::old('title_en', $en_translation->title), array('placeholder' => 'Category title in English', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-12">
            {!! Form::text('title_nb', Input::old('title_nb', $nb_translation->title), array('placeholder' => 'Category title in Norwegian', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-12">
            {{ Form::label('description_en', 'Description in english') }}
            {!! Form::textarea('description_en', Input::old('description_en', $en_translation->description), 
                    array(
                        'placeholder' => 'Description in English',
                        'maxlength'=>'5000',
                        'class' => 'generic_input'
                    ) 
                ); 
            !!}
        </div>

        <div class="col-md-12">
            {{ Form::label('description_nb', 'Description in norwegian') }}
            {!! Form::textarea('description_nb', Input::old('description_nb', $nb_translation->description), 
                    array(
                        'placeholder' => 'Description in Norwegian',
                        'maxlength'=>'5000',
                        'class' => 'generic_input'
                    ) 
                ); 
            !!}
        </div>



        <div class="col-md-12">
            {!! Form::submit('Update category', array('class' => 'generic_submit') )!!}
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