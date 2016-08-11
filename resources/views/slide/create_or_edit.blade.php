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
        <h1 class="capital center">Slideshow item</h1>
        
        @if(! empty($slide->image))
            <img class="b-lazy" data-src="{{route('image', $slide->image)}}?w=400&fit=crop" src="{{ asset('images/loading.gif') }}"/>
        @endif
        {!! Form::model($slide, array('route' => array($route, $slide->id), 'method' => $method, 'files' => true )) !!}
            <div class="col-md-12">
                 {!! Form::file('image', Input::old('image'), array('placeholder' => 'image', 'class' => 'generic_input' )); !!}
            </div>

            <div class="col-md-12">
                {!! Form::text('url', Input::old('url'), array('placeholder' => 'Optional link', 'class' => 'generic_input' )); !!}
            </div>

            <div class="col-md-6">
                {!! Form::textarea('description_en', Input::old('description_en'), array('placeholder' => 'Optional Description in English', 'class' => 'generic_input' )); !!}
            </div>
            
            <div class="col-md-6">
                {!! Form::textarea('description_nb', Input::old('description_nb'), array('placeholder' => 'Optional Description in Norwegian', 'class' => 'generic_input' )); !!}
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
