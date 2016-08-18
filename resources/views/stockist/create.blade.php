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


    <h1 class="capital center">Add a stockist</h1>

    {!! Form::model($stockist, array('route' => array('stockist.store') , 'files' => true)  ) !!}


        <div class="col-md-12">
            {{ Form::label('thumbnail', 'Main image') }}
            {!! Form::file('thumbnail', Input::old('thumbnail'), array('placeholder' => 'Thumbnail', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-12">
            {!! Form::text('title', Input::old('title'), array('placeholder' => 'Title', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-12">
            {!! Form::textarea('address', Input::old('address'), array('placeholder' => 'address', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-6">
            {!! Form::text('lat', Input::old('lat'), array('placeholder' => 'latitude', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-6">
            {!! Form::text('lng', Input::old('lng '), array('placeholder' => 'longitude', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-12">
            {!! Form::submit('Stockist', array('class' => 'generic_submit') )!!}
        </div>

    {!! Form::close() !!}
</div>

<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
<script>

$( document ).ready(function() {

        $('textarea').ckeditor();
});

</script>


@stop
