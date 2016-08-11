@extends('master_page')
@section('content')
<div class="col-md-12">
    <div class="wrapper">
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

    </div>
</div>

<div class="col-md-12">
    <div class="wrapper">
        <h1 class="capital center">Shipping option</h1>

        {!! Form::model($shipping, array('route' => array($route, $shipping->id), 'method' => $method )) !!}
        
        <div class="col-md-3">
            {!! Form::text('country', Input::old('country'), array('placeholder' => 'country', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-3">
            {!! Form::text('country_code', Input::old('country_code'), array('placeholder' => 'Country code', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-3">
            {!! Form::text('weight', Input::old('weight'), array('placeholder' => 'Weight in grams', 'class' => 'generic_input' )); !!}
        </div>
        
        <div class="col-md-3">
            {!! Form::text('price', Input::old('price'), array('placeholder' => 'Price in krona', 'class' => 'generic_input' )); !!}
        </div>

        <div class="col-md-12">
            {!! Form::submit('add', array('class' => 'generic_submit') )!!}
        </div>
    {!! Form::close() !!}
    </div>
</div>
@stop

@section('scripts')
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
<script>
    $( document ).ready(function() { 
        $('textarea').ckeditor();
    });
</script>
@stop
