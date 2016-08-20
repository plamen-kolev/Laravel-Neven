@extends('master_page')

@section('content')
    <div class="col-md-12">
        <div class="wrapper">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                  <span class="sr-only">Error:</span>
                    {{ $error }}
                </div>
            @endforeach
            {!! Form::model($object, array('route' => array($route, $object->id), 'method' => $method, 'files' => true )) !!}
            <p>
                @if( ! empty($object->video))
                <video autoplay loop poster="" id="landing_video" style="width:100px;" >
                    <source src="{{asset("videos/$object->video")}}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                @endif
                {!! Form::file('video', Input::old('video'), array('placeholder' => 'Video', 'class' => 'generic_input' )); !!}
            </p>

            <p>
                @if( ! empty($object->image))
                    <img src="{{asset("videos/thumbnails/$object->image")}}" alt="" style="width:400px;"/>
                @endif
                {!! Form::file('image', Input::old('image'), array('placeholder' => 'Optional image', 'class' => 'generic_input' )); !!}
            </p>

            <p>
                {!! Form::text('title_en', Input::old('title_en'), array('placeholder' => 'Landing title in English', 'class' => 'generic_input' )); !!}
            </p>

            <p>
                {!! Form::text('title_nb', Input::old('title_nb'), array('placeholder' => 'Landing title in Norwegian', 'class' => 'generic_input' )); !!}
            </p>
            <p>
                {!! Form::submit('Submit', array('class' => 'generic_submit') )!!}
            </p>
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
